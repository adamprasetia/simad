<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends MY_Controller {

	private $limit = 15;
	private $table = 'module';

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
		$module_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$module_view['offset'] = $offset;
		$module_view['paging'] = gen_paging($total,$this->limit);
		$module_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/module_view', $module_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nama Modul', 'trim|required');
		$this->form_validation->set_rules('parent', 'Parent', 'trim');
		$this->form_validation->set_rules('link', 'Link', 'trim');
		$this->form_validation->set_rules('icon', 'Icon', 'trim');
		$this->form_validation->set_rules('order', 'Order', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$name 		= $this->input->post('name');
		$parent 	= $this->input->post('parent');
		$link 		= $this->input->post('link');
		$icon 		= $this->input->post('icon');
		$order 		= $this->input->post('order');

		$data = array(
			'name' => $name,
			'parent' => $parent,
			'link' => $link,
			'icon' => $icon,
			'order' => $order,
		);

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
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$data['content'] = $this->load->view('contents/form_module_view', [
				'action'=>base_url('module/add').get_query_string()
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
			$module_view['data'] = $this->db->get($this->table)->row();
			$module_view['action'] = base_url('module/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_module_view',$module_view,true);

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
