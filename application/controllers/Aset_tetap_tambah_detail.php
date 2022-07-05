<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_tambah_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap_tambah_detail';
	public $module = 'aset_tetap_tambah_detail';
	public $module_parent = 'aset_tetap_tambah';
	public $title = 'PENAMBAHAN ASET TETAP DETAIL';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select($this->table.'.*,barang.kode as kode_barang,barang.nama as nama_barang,barang.kib, concat(DATE_FORMAT(aset_tetap.tanggal,"%Y%m%d"),aset_tetap.id) as kode_unik');
		$this->db->join('aset_tetap', 'aset_tetap.id='.$this->table.'.id_aset_tetap', 'left');
		$this->db->join('barang', 'barang.kode=aset_tetap.kode_barang', 'left');

		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('barang.kode', $search);
			$this->db->or_like('barang.nama', $search);
			$this->db->group_end();
		}
		$id_aset_tetap_tambah = $this->input->get('id_aset_tetap_tambah');
		if(!empty($id_aset_tetap_tambah)){
			$this->db->where('id_aset_tetap_tambah', $id_aset_tetap_tambah);
		}

	}
   
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$content['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$content['offset'] = $offset;
		$content['paging'] = gen_paging($total,$this->limit);
		$content['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/'.$this->module.'_view', $content, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('id_aset_tetap', 'Kode Unik', 'trim|required');
		$this->form_validation->set_rules('umur', 'Umur', 'trim');
		$this->form_validation->set_rules('nilai', 'Nilai', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$id_parent	= $this->input->post('id_'.$this->module_parent);
		$id_aset_tetap	= $this->input->post('id_aset_tetap');
		$umur	    = $this->input->post('umur');
		$nilai	    = $this->input->post('nilai');

		$data = array(
			'id_'.$this->module_parent => $id_parent,
			'id_aset_tetap' => $id_aset_tetap,
			'umur' => format_uang($umur),
			'nilai' => format_uang($nilai),
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
			$data['script'] = $this->load->view('script/'.$this->module.'_script', '', true);
			$data['content'] = $this->load->view('contents/form_'.$this->module.'_view', [
				'action'=>base_url($this->module.'/add').get_query_string()
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
			$this->db->trans_start();
			$data = $this->_set_data();
			$this->db->insert($this->table, $data);

			$this->db->where('id', $data['id_aset_tetap']);
			$this->db->set('umur', 'umur+'.$data['umur'], false);
			$this->db->set('nilai', 'nilai+'.$data['nilai'], false);
			$this->db->update('aset_tetap');
			$this->db->trans_complete();
			
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$this->db->insert_id(), 'action'=>'insert', 'message'=>'Data berhasil disimpan');
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
			$this->db->where($this->table.'.id', $id);
			$this->db->select($this->table.'.*,barang.kode as kode_barang,barang.nama as nama_barang,barang.kib, concat(DATE_FORMAT(aset_tetap.tanggal,"%Y%m%d"),aset_tetap.id) as kode_unik');
			$this->db->join('aset_tetap', 'aset_tetap.id='.$this->table.'.id_aset_tetap', 'left');
			$this->db->join('barang', 'barang.kode=aset_tetap.kode_barang', 'left');
			$content['data'] = $this->db->get($this->table)->row();
			$content['data']->kib = config_item('kib')[$content['data']->kib]['id'];
			$content['data']->nilai = number_format($content['data']->nilai);
			$content['data']->umur = number_format($content['data']->umur);
			$content['action'] = base_url($this->module.'/edit/'.$id).get_query_string();
			$data['script'] = $this->load->view('script/'.$this->module.'_script', '', true);
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
			$this->db->trans_start();
			$before = $this->db->where('id', $id)->get($this->table)->row();
			$umur = $data['umur']-$before->umur;
			$nilai = $data['nilai']-$before->nilai;

			$this->db->where('id', $before->id_aset_tetap);
			$this->db->set('umur', 'umur+'.$umur, false);
			$this->db->set('nilai', 'nilai+'.$nilai, false);
			$this->db->update('aset_tetap');

			$this->db->update($this->table, $data, ['id'=>$id]);
			$this->db->trans_complete();
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
			$this->db->trans_start();
			$before = $this->db->where('id', $id)->get($this->table)->row();
			$this->db->where('id', $before->id_aset_tetap);
			$this->db->set('umur', 'umur-'.$before->umur, false);
			$this->db->set('nilai', 'nilai-'.$before->nilai, false);
			$this->db->update('aset_tetap');

			$this->db->delete($this->table, ['id'=>$id]);
			$this->db->trans_complete();
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
