<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {

	private $limit = 15;
	private $table = 'role';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$search = $this->input->get('search');
		if ($search) {
			$this->db->like('name', $search);
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$role_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$role_view['offset'] = $offset;
		$role_view['paging'] = gen_paging($total,$this->limit);
		$role_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/role_view', $role_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nama Role', 'trim|required');
		$this->form_validation->set_rules('module[]', 'Modul', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$name 		= $this->input->post('name');

		$data = array(
			'name' => $name,
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
			$data['content'] = $this->load->view('contents/form_role_view', [
				'action'=>base_url('role/add').get_query_string()
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
			$this->db->trans_start();
			$this->db->insert($this->table, $data);
			$error = $this->db->error();
			$message = '';
			if(!empty($error['message'])){
				$message = $error['message'];
			}
			$id = $this->db->insert_id();
			
			$modules = $this->input->post('module');
			$data_module = [];
			foreach ($modules as $module) {
				$data_module[] = [
					'id_role'=>$id,
					'id_module'=>$module
				];
			}
			$this->db->insert_batch('role_module', $data_module);
			$error = $this->db->error();
			if(!empty($error['message'])){
				$message = $error['message'];
			}
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$message);
			}else{
				$response = array('id'=>$id, 'action'=>'insert', 'message'=>'Data berhasil disimpan');
			}

			echo json_encode($response);
		}
	}

	public function edit($id='')
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$this->db->where('id', $id);
			$role_view['data'] = $this->db->get($this->table)->row();
			$data_modules = $this->db->where('id_role', $id)->get('role_module')->result();
			$data_module = [];
			foreach ($data_modules as $row) {
				$data_module[] = $row->id_module;
			}
			$role_view['data_module'] = $data_module;
			$role_view['action'] = base_url('role/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_role_view',$role_view,true);

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
			$this->db->update($this->table, $data, ['id'=>$id]);

			$modules = $this->input->post('module');
			$data_module = [];
			foreach ($modules as $module) {
				$data_module[] = [
					'id_role'=>$id,
					'id_module'=>$module
				];
			}
			$this->db->delete('role_module', ['id_role'=>$id]);
			$error = $this->db->error();
			if(!empty($error['message'])){
				$message = $error['message'];
			}

			$this->db->insert_batch('role_module', $data_module);
			$error = $this->db->error();
			if(!empty($error['message'])){
				$message = $error['message'];
			}
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$message);
			}else{
				$response = array('id'=>$id, 'action'=>'insert', 'message'=>'Data berhasil disimpan');
			}

			echo json_encode($response);
		}
	}

	public function delete($id = '')
	{
		if ($id) {
			$data = $this->_set_data('delete');
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
