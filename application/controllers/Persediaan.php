<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persediaan extends MY_Controller {

	private $limit = 15;
	private $table = 'persediaan';
	private $module = 'persediaan';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select('a.*, b.nama as nama_barang,b.satuan as satuan');
		$this->db->join('barang_persediaan b','a.kode_barang=b.kode','left');
		$this->db->where('a.kode_skpd', $this->session_login['skpd_session']);
		if(!empty($this->input->get('popup'))){
			$this->db->where('a.stok >', 0);
		}
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('a.kode', $search);
			$this->db->or_like('b.nama', $search);
			$this->db->group_end();
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table.' a');
		$this->_filter();
		$content['data'] 	= $this->db->get($this->table.' a', $this->limit, $offset)->result();
		$content['offset'] = $offset;
		$content['paging'] = gen_paging($total,$this->limit);
		$content['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/'.$this->module.'_view', $content, TRUE);

		$this->load->view(!empty($this->input->get('popup'))?'modals/template_view':'template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('stok', 'Jumlah Tersedia', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$kode_barang	= $this->input->post('kode_barang');
		$stok		= $this->input->post('stok');

		$data = array(
            'kode_skpd'=>$this->session_login['skpd_session'],
			'kode_barang' => $kode_barang,
			'stok' => $stok,
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
            $data['script'] = $this->load->view('script/persediaan_script', '', true);
			$data['content'] = $this->load->view('contents/form_persediaan_view', [
				'action'=>base_url('persediaan/add').get_query_string()
			],true);

			if(!validation_errors())
			{
				$this->load->view(!empty($this->input->get('popup'))?'modals/template_view':'template_view', $data);
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
			$this->db->select('a.*, b.nama as nama_barang, b.satuan as satuan');
			$this->db->where('a.id', $id);
			$this->db->join('barang_persediaan b', 'a.kode_barang=b.kode', 'left');
			$content['data'] = $this->db->get($this->table.' a')->row();
			$content['action'] = base_url('persediaan/edit/'.$id).get_query_string();
            $data['script'] = $this->load->view('script/persediaan_script', '', true);
			$data['content'] = $this->load->view('contents/form_persediaan_view',$content,true);

			if(!validation_errors())
			{
				$this->load->view(!empty($this->input->get('popup'))?'modals/template_view':'template_view', $data);
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
