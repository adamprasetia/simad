<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap_detail';
	public $module = 'aset_tetap_detail';
	public $module_parent = 'aset_tetap';
	public $title = 'PEROLEHAN ASET TETAP DETAIL';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		if(!empty($this->input->get('popup'))){
			$this->db->select($this->table.'.*, concat(kib,DATE_FORMAT('.$this->table.'.created_at,"%Y%m%d"),'.$this->table.'.id) as kode_unik, aset_tetap.nomor');
			$this->db->join('aset_tetap','aset_tetap.id='.$this->table.'.id_aset_tetap','left');
		}else{
			$this->db->select($this->table.'.*, concat(kib,DATE_FORMAT(created_at,"%Y%m%d"),id) as kode_unik');
		}

		$kib = $this->input->get('kib');
		if ($kib) {
			$this->db->where('kib', $kib);
		}
		$tahun = $this->input->get('tahun');
		if ($tahun) {
			$this->db->where('year(aset_tetap.tanggal)', $tahun);
		}
		$kode_barang = $this->input->get('kode_barang');
		if ($kode_barang) {
			$this->db->where('kode_barang', $kode_barang);
		}
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('kode_barang', $search);
			$this->db->or_like('nama_barang', $search);
			$this->db->or_like('concat(kib,DATE_FORMAT('.$this->table.'.created_at,"%Y%m%d"),'.$this->table.'.id)', $search);
			$this->db->group_end();
		}
        $parent = $this->input->get('id_'.$this->module_parent);
		if(!empty($parent)){
			$this->db->where('id_'.$this->module_parent, $parent);
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

		$this->load->view(!empty($this->input->get('popup'))?'modals/template_view':'template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
		$this->form_validation->set_rules('umur', 'Umur', 'trim');
		if($this->uri->segment(1)=='add'){
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
		}
		$this->form_validation->set_rules('nilai', 'Nilai', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$id_parent	= $this->input->post('id_'.$this->module_parent);
		$kib	= $this->input->post('kib');
		$kode_barang	= $this->input->post('kode_barang');
		$nama_barang	    = $this->input->post('nama_barang');
		$umur	    = $this->input->post('umur');
		$nilai	    = $this->input->post('nilai');
		$info	    = $this->input->post('info');

		$data = array(
			'id_'.$this->module_parent => $id_parent,
			'kib' => $kib,
			'kode_barang' => $kode_barang,
			'nama_barang' => $nama_barang,
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
			$jumlah = $this->input->post('jumlah');
			$data = [];
			for ($i=1; $i <= $jumlah; $i++) { 
				$data[] = $this->_set_data();
			}
			$this->db->insert_batch($this->table, $data);
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
			$content['data'] = $this->db->get($this->table)->row();
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
