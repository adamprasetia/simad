<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_report extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap';
	public $module = 'aset_tetap_report';
	public $title = 'ASET TETAP';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select($this->table.'.*, year(tanggal) as tahun,barang.nama as nama_barang,barang.kib');
		
		$kode_skpd = $this->input->get('kode_skpd');
		if(!empty($kode_skpd)){
			$this->db->where('kode_skpd', $kode_skpd);
		}else{
			$this->db->where('kode_skpd', $this->session_login['skpd_session']);
		}
		$this->db->join('barang','barang.kode='.$this->table.'.kode_barang','left');

		$this->db->where('status', 1);
		$kib = $this->input->get('kib');
		if ($kib) {
			$this->db->where('barang.kib', $kib);
		}
		$tahun = $this->input->get('tahun');
		if ($tahun) {
			$this->db->where('year('.$this->table.'.tanggal)', $tahun);
		}else{
			$this->db->where('year('.$this->table.'.tanggal)', $this->session_login['tahun_session']);
		}
		$kode_barang = $this->input->get('kode_barang');
		if ($kode_barang) {
			$this->db->where('barang.kode', $kode_barang);
		}
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('barang.kode', $search);
			$this->db->or_like($this->table.'.nomor', $search);
			$this->db->or_like('barang.nama', $search);
			$this->db->or_like('concat(kib,DATE_FORMAT('.$this->table.'.tanggal,"%Y%m%d"),'.$this->table.'.id)', $search);
			$this->db->group_end();
		}
	}
	public function index()
	{
        $kib = $this->input->get('kib');
		$this->_filter();
		$content['lokasi'] 	= $this->session_login['skpd_session'];
		$content['data'] 	= $this->db->get($this->table)->result();
		$this->load->view('reports/'.$this->table.'_'.$kib.'_report', $content);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$kode_barang	= $this->input->post('kode_barang');
		$tanggal	= $this->input->post('tanggal');
		$kib	= $this->input->post('kib');
		$umur	    = $this->input->post('umur');
		$nilai	    = $this->input->post('nilai');
		$info	    = $this->input->post('info');

		$data = array(
			'kode_skpd' => $this->session_login['skpd_session'],
			'tanggal' => format_ymd($tanggal),
			'kode_barang' => $kode_barang,
			'umur' => format_uang($umur),
			'nilai' => format_uang($nilai),
			'info' => $info,
		);
		/* kib */
		$kib_info = $this->db->select('a.*, b.nomor')->where('nomor',$kib)->order_by('urutan asc')->join('kib b','a.id_kib=b.id','left')->get('kib_info a')->result();
		$info_lain = [];
		foreach ($kib_info as $row) {
			$info_lain[$row->kode] = $this->input->post($row->kode);
		}
		$data['info_lain'] = json_encode($info_lain);

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
			$this->db->insert('aset_tetap', $data);			
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
			$this->db->select('a.*, b.nama as nama_barang, b.kib');
			$this->db->where('a.id', $id);
			$this->db->join('barang b', 'a.kode_barang=b.kode', 'left');
			$content['data'] = $this->db->get($this->table.' a')->row();
			$content['data']->nilai = number_format($content['data']->nilai);
			$content['data']->umur = number_format($content['data']->umur);
			$content['data']->info_lain = json_decode($content['data']->info_lain);
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
			$this->db->trans_start();
			$data = $this->_set_data('edit');
			$this->db->update($this->table, $data, ['id'=>$id]);
			$this->db->update('aset_tetap', $data, ['id'=>$id]);
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
			$this->db->delete($this->table, ['id'=>$id]);
			$this->db->delete('aset_tetap', ['id'=>$id]);
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
