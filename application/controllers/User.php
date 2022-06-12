<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	private $limit = 15;
	private $table = 'user';

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
		$user_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$user_view['offset'] = $offset;
		$user_view['paging'] = gen_paging($total,$this->limit);
		$user_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/user_view', $user_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules($type = 'add')
	{
		$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim');
		$this->form_validation->set_rules('phone', 'Telepon', 'trim');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		if($type == 'add'){
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
		}else{
			$this->form_validation->set_rules('password', 'Password', 'trim');
		}
	}
	
	private function _set_data($type = 'add')
	{
		$fullname 		= $this->input->post('fullname');
		$email 			= $this->input->post('email');
		$phone 			= $this->input->post('phone');
		$username 		= $this->input->post('username');
		$password 		= $this->input->post('password');

		$data = array(
			'fullname' => $fullname,
			'email' => $email,
			'phone' => $phone,
			'username' => $username,
		);
		if(!empty($password)){
			$data['password'] = password_hash($password, PASSWORD_BCRYPT);
		}

		if($type == 'add'){
			$data['created_by'] = get_id_user_login();
			$data['created_at'] = date('Y-m-d H:i:s');
		}
		else if($type == 'edit'){
			$data['modified_by'] = get_id_user_login();
			$data['modified_at'] = date('Y-m-d H:i:s');
		}
		else if($type == 'delete'){
			$data = [
				'modified_by' => get_id_user_login(),
				'deleted_at' => date('Y-m-d H:i:s')
			];
		}

		return $data;
	}
	public function add()
	{
		$this->_set_rules('add');
		if ($this->form_validation->run()===FALSE) {
			$data['content'] = $this->load->view('contents/form_user_view', [
				'action'=>base_url('user/add').get_query_string()
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
			
			$roles = $this->input->post('role');
			$data_role = [];
			foreach ($roles as $role) {
				$data_role[] = [
					'id_user'=>$id,
					'id_role'=>$role
				];
			}
			$this->db->insert_batch('role_user', $data_role);
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
		$this->_set_rules('edit');
		if ($this->form_validation->run()===FALSE) {
			$this->db->where('id', $id);
			$user_view['data'] = $this->db->get($this->table)->row();
			$data_roles = $this->db->where('id_user', $id)->get('role_user')->result();
			$data_role = [];
			foreach ($data_roles as $row) {
				$data_role[] = $row->id_role;
			}
			$user_view['data_role'] = $data_role;
			$user_view['action'] = base_url('user/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_user_view',$user_view,true);

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

			$roles = $this->input->post('role');
			$data_role = [];
			foreach ($roles as $role) {
				$data_role[] = [
					'id_user'=>$id,
					'id_role'=>$role
				];
			}
			$this->db->delete('role_user', ['id_user'=>$id]);
			$error = $this->db->error();
			if(!empty($error['message'])){
				$message = $error['message'];
			}

			$this->db->insert_batch('role_user', $data_role);
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

	public function change_password(){
		$this->form_validation->set_rules('oldpass', 'Password Lama', 'callback_password_check');
        $this->form_validation->set_rules('newpass', 'Password Baru', 'required');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password Baru', 'required|matches[newpass]');

		if ($this->form_validation->run()===FALSE) {
			$data['content'] = $this->load->view('contents/change_password_view', '', true);

			if(!validation_errors())
			{
				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan !', 'message'=>strip_tags(validation_errors())));
			}

		}else{
			$this->db->update($this->table, ['password' => password_hash($this->input->post('newpass'), PASSWORD_BCRYPT)], ['id'=>get_id_user_login()]);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('action'=>'edit', 'message'=>'Password berhasil diganti');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}
			echo json_encode($response);
		}

	}
	public function password_check($oldpass)
    {
		$userdata = $this->db->where('id', get_id_user_login())->get('user')->row();
		if (password_verify($oldpass, $userdata->password)) { 
			return true;
		} else { 
			$this->form_validation->set_message('password_check', 'Password Lama Tidak Cocok');
            return false;
		}
    }


}
