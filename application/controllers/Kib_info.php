<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kib_info extends MY_Controller {

	private $limit = 15;
	private $table = 'kib_info';

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
			$this->db->or_like('nama', $search);
			$this->db->group_end();
		}
        $id_kib = $this->input->get('id_kib');
		if(!empty($id_kib)){
			$this->db->where('id_kib', $id_kib);
		}

	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$kib_info_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$kib_info_view['offset'] = $offset;
		$kib_info_view['paging'] = gen_paging($total,$this->limit);
		$kib_info_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/kib_info_view', $kib_info_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode', 'Kode', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('tipe', 'Tipe', 'trim|required');
		$this->form_validation->set_rules('awalan', 'Awalan', 'trim');
		$this->form_validation->set_rules('akhiran', 'Akhiran', 'trim');
		$this->form_validation->set_rules('pilihan', 'Urutan', 'trim');
		$this->form_validation->set_rules('pilihan', 'Pilihan', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$id_kib	= $this->input->post('id_kib');
		$kode	= $this->input->post('kode');
		$nama	= $this->input->post('nama');
		$tipe	    = $this->input->post('tipe');
		$awalan	    = $this->input->post('awalan');
		$akhiran	    = $this->input->post('akhiran');
		$urutan	    = $this->input->post('urutan');
		$pilihan	    = $this->input->post('pilihan');

		$data = array(
			'id_kib' => $id_kib,
			'kode' => $kode,
			'nama' => $nama,
			'tipe' => $tipe,
			'awalan' => $awalan,
			'akhiran' => $akhiran,
			'urutan' => $urutan,
			'pilihan' => $pilihan,
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
			$data['script'] = $this->load->view('script/kib_info_script', '', true);
			$data['content'] = $this->load->view('contents/form_kib_info_view', [
				'action'=>base_url('kib_info/add').get_query_string()
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
			$this->db->where('id', $id);
			$kib_info_view['data'] = $this->db->get($this->table)->row();
			$kib_info_view['action'] = base_url('kib_info/edit/'.$id).get_query_string();
			$data['script'] = $this->load->view('script/kib_info_script', '', true);
			$data['content'] = $this->load->view('contents/form_kib_info_view',$kib_info_view,true);

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
