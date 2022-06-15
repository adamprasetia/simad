<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_tambah_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap_tambah_detail';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('kode_barang', $search);
			$this->db->or_like('nama_barang', $search);
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
		$aset_tetap_tambah_detail_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$aset_tetap_tambah_detail_view['offset'] = $offset;
		$aset_tetap_tambah_detail_view['paging'] = gen_paging($total,$this->limit);
		$aset_tetap_tambah_detail_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/aset_tetap_tambah_detail_view', $aset_tetap_tambah_detail_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
		$this->form_validation->set_rules('id_aset_tetap_detail', 'Nomor Perolehan', 'trim|required');
		$this->form_validation->set_rules('umur', 'Umur', 'trim');
		$this->form_validation->set_rules('nilai', 'Nilai', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$id_aset_tetap_tambah	= $this->input->post('id_aset_tetap_tambah');
		$id_aset_tetap_detail	= $this->input->post('id_aset_tetap_detail');
		$nomor	= $this->input->post('nomor');
		$tahun	= $this->input->post('tahun');
		$kib	= $this->input->post('kib');
		$kode_barang	= $this->input->post('kode_barang');
		$nama_barang	    = $this->input->post('nama_barang');
		$umur	    = $this->input->post('umur');
		$nilai	    = $this->input->post('nilai');
		$info	    = $this->input->post('info');

		$data = array(
			'id_aset_tetap_tambah' => $id_aset_tetap_tambah,
			'id_aset_tetap_detail' => $id_aset_tetap_detail,
			'kib' => $kib,
			'kode_barang' => $kode_barang,
			'nama_barang' => $nama_barang,
			'tahun' => $tahun,
			'nomor' => $nomor,
			'umur' => format_uang($umur),
			'nilai' => format_uang($nilai),
			'info' => $info,
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
			$data['script'] = $this->load->view('script/aset_tetap_tambah_detail_script', '', true);
			$data['content'] = $this->load->view('contents/form_aset_tetap_tambah_detail_view', [
				'action'=>base_url('aset_tetap_tambah_detail/add').get_query_string()
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
			$aset_tetap_tambah_detail_view['data'] = $this->db->get($this->table)->row();
			$aset_tetap_tambah_detail_view['data']->nilai = number_format($aset_tetap_tambah_detail_view['data']->nilai);
			$aset_tetap_tambah_detail_view['data']->umur = number_format($aset_tetap_tambah_detail_view['data']->umur);
			$aset_tetap_tambah_detail_view['action'] = base_url('aset_tetap_tambah_detail/edit/'.$id).get_query_string();
			$data['script'] = $this->load->view('script/aset_tetap_tambah_detail_script', '', true);
			$data['content'] = $this->load->view('contents/form_aset_tetap_tambah_detail_view',$aset_tetap_tambah_detail_view,true);

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
