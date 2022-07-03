<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_hapus_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap_hapus_detail';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select($this->table.'.*,barang.kode as kode_barang,barang.nama as nama_barang,barang.kib,aset_tetap.nomor, concat(DATE_FORMAT(aset_tetap_detail.created_at,"%Y%m%d"),aset_tetap_detail.id) as kode_unik');
		$this->db->join('aset_tetap_detail', 'aset_tetap_detail.id='.$this->table.'.id_aset_tetap_detail', 'left');
		$this->db->join('barang', 'barang.kode=aset_tetap_detail.kode_barang', 'left');
		$this->db->join('aset_tetap', 'aset_tetap.id=aset_tetap_detail.id_aset_tetap', 'left');

		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('barang.kode', $search);
			$this->db->or_like('barang.nama', $search);
			$this->db->group_end();
		}
        $id_aset_tetap_hapus = $this->input->get('id_aset_tetap_hapus');
		if(!empty($id_aset_tetap_hapus)){
			$this->db->where('id_aset_tetap_hapus', $id_aset_tetap_hapus);
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
		$data['content'] 	= $this->load->view('contents/aset_tetap_hapus_detail_view', $content, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('id_aset_tetap_detail', 'Kode Unik', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$id_aset_tetap_hapus	= $this->input->post('id_aset_tetap_hapus');
		$id_aset_tetap_detail	= $this->input->post('id_aset_tetap_detail');
		$info	    = $this->input->post('info');
		$nilai	    = $this->input->post('nilai');

		$data = array(
			'id_aset_tetap_hapus' => $id_aset_tetap_hapus,
			'id_aset_tetap_detail' => $id_aset_tetap_detail,
			'info' => $info,
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
			$data['script'] = $this->load->view('script/aset_tetap_hapus_detail_script', '', true);
			$data['content'] = $this->load->view('contents/form_aset_tetap_hapus_detail_view', [
				'action'=>base_url('aset_tetap_hapus_detail/add').get_query_string()
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
			$this->db->select($this->table.'.*,barang.kode as kode_barang,barang.nama as nama_barang,barang.kib,aset_tetap.nomor, concat(DATE_FORMAT(aset_tetap_detail.created_at,"%Y%m%d"),aset_tetap_detail.id) as kode_unik');
			$this->db->join('aset_tetap_detail', 'aset_tetap_detail.id='.$this->table.'.id_aset_tetap_detail', 'left');
			$this->db->join('barang', 'barang.kode=aset_tetap_detail.kode_barang', 'left');
			$this->db->join('aset_tetap', 'aset_tetap.id=aset_tetap_detail.id_aset_tetap', 'left');	
			$content['data'] = $this->db->get($this->table)->row();
			$content['data']->kib = config_item('kib')[$content['data']->kib]['id'];
			$content['data']->nilai = number_format($content['data']->nilai);
			$content['action'] = base_url('aset_tetap_hapus_detail/edit/'.$id).get_query_string();
			$data['script'] = $this->load->view('script/aset_tetap_hapus_detail_script', '', true);
			$data['content'] = $this->load->view('contents/form_aset_tetap_hapus_detail_view',$content,true);

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
