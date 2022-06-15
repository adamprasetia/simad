<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kib extends MY_Controller {

	private $limit = 15;
	private $table = 'kib';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('kode', $search);
			$this->db->or_like('nomor', $search);
			$this->db->or_like('nama', $search);
			$this->db->group_end();
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$kib_view['data'] 	= $this->db->order_by('id desc')->get($this->table, $this->limit, $offset)->result();
		$kib_view['offset'] = $offset;
		$kib_view['paging'] = gen_paging($total,$this->limit);
		$kib_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/kib_view', $kib_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode', 'Kode', 'trim|required');
		$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$kode		= $this->input->post('kode');
		$nomor	= $this->input->post('nomor');
		$nama	    = $this->input->post('nama');

		$data = array(
			'kode' => $kode,
			'nomor' => $nomor,
			'nama' => $nama
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
			$data['content'] = $this->load->view('contents/form_kib_view', [
				'action'=>base_url('kib/add').get_query_string(),
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
				$response = array('id'=>$id, 'redirect'=>base_url('kib_detail/add?kib_id='.$id), 'action'=>'insert', 'message'=>'Data berhasil disimpan');
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
			$kib_view['data'] = $this->db->get($this->table)->row();
			$kib_view['action'] = base_url('kib/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_kib_view',$kib_view,true);

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
