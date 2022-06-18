<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap';
	public $module = 'aset_tetap';
	public $title = 'Perolehan Aset Tetap';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$skpd_session = $this->session_login['skpd_session'];
		if(!empty($skpd_session)){
			$this->db->where('kode_skpd', $skpd_session);
		}
		$tahun_session = $this->session_login['tahun_session'];
		if(!empty($tahun_session)){
			$this->db->where('year(tanggal)', $tahun_session);
		}
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('nomor', $search);
			$this->db->or_like('uraian', $search);
			$this->db->group_end();
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$content['data'] 	= $this->db->order_by('id desc')->get($this->table, $this->limit, $offset)->result();
		$content['offset'] = $offset;
		$content['paging'] = gen_paging($total,$this->limit);
		$content['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/'.$this->module.'_view', $content, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim');
		$this->form_validation->set_rules('uraian', 'Uraian', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$nomor		= $this->input->post('nomor');
		$tanggal	= $this->input->post('tanggal');
		$uraian	    = $this->input->post('uraian');

		$data = array(
			'nomor' => $nomor,
			'tanggal' => format_ymd($tanggal),
			'uraian' => $uraian,
			'kode_skpd' => $this->session_login['skpd_session'],
		);

		if($type == 'add'){
			$data['created_by'] = $this->session_login['id'];
			$data['created_at'] = date('Y-m-d H:i:s');
		}
		else if($type == 'edit'){
			$data['modified_by'] = $this->session_login['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
		}
		else if($type == 'delete'){
			$data = [
				'modified_by' => $this->session_login['id'],
				'deleted_at' => date('Y-m-d H:i:s')
			];
		}

		return $data;
	}
	public function add()
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$data['content'] = $this->load->view('contents/form_'.$this->module.'_view', [
				'action'=>base_url($this->module.'/add').get_query_string(),
			],true);

			if(!validation_errors())
			{
				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>strip_tags(validation_errors())));
			}

		}else{
			$data = $this->_set_data();
			$this->db->insert($this->table, $data);
			$id = $this->db->insert_id();
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$id, 'redirect'=>base_url($this->module.'_detail/add?id_'.$this->module.'='.$id), 'action'=>'insert', 'message'=>'Data berhasil disimpan');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}

			echo json_encode($response);
		}
	}

	public function edit($id='')
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$this->db->where('id', $id);
			$content['data'] = $this->db->get($this->table)->row();
			$content['action'] = base_url($this->module.'/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_'.$this->module.'_view',$content,true);

			if(!validation_errors())
			{
				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'error', 'title'=>'Terjadi Kesalahan !', 'message'=>strip_tags(validation_errors())));
			}

		}else{
			$data = $this->_set_data('edit');
			$this->db->update($this->table, $data, ['id'=>$id]);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$id, 'action'=>'update', 'message'=>'Data berhasil disimpan');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}

			echo json_encode($response);
		}
	}

	public function delete($id = '')
	{
		if ($id) {
			$this->db->delete($this->table, ['id'=>$id]);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$id, 'action'=>'delete', 'message'=>'Data berhasil dihapus');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}
			echo json_encode($response);
		}
	}
}
