<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang_persediaan extends MY_Controller {

	private $limit = 15;
	private $table = 'barang_persediaan';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->where('deleted_at', null);
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('kode', $search);
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
		$barang_persediaan_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$barang_persediaan_view['offset'] = $offset;
		$barang_persediaan_view['paging'] = gen_paging($total,$this->limit);
		$barang_persediaan_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/barang_persediaan_view', $barang_persediaan_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama Barang', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$kode		= $this->input->post('kode');
		$nama		= $this->input->post('nama');

		$data = array(
			'kode' => $kode,
			'nama' => $nama,
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
			$data['content'] = $this->load->view('contents/form_barang_persediaan_view', [
				'action'=>base_url('barang_persediaan/add').get_query_string()
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
			$barang_persediaan_view['data'] = $this->db->get($this->table)->row();
			$barang_persediaan_view['action'] = base_url('barang_persediaan/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_barang_persediaan_view',$barang_persediaan_view,true);

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
			$this->db->update($this->table, $data,['id'=>$id]);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$id, 'action'=>'delete', 'message'=>'Data berhasil dihapus');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}
			echo json_encode($response);
		}
	}
	
	public function api()
	{
		$search = $this->input->get('search');
		$kib = $this->input->get('kib');
		if(!empty($kib)){
			$this->db->like('kode',$kib,'after');
		}
		$this->db->group_start();
		$this->db->like('nama', $search);
		$this->db->or_like('kode', $search);
		$this->db->group_end();
		$result = $this->db->select('kode as id,concat(kode," | ",nama) as text')->get($this->table, 10, 0)->result_array();
		// echo $this->db->last_query();exit;
		echo json_encode(['results'=>$result]);
	}

}
