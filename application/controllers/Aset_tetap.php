<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap';
	public $module = 'aset_tetap';
	public $title = 'ASET TETAP';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select($this->table.'.*, concat(DATE_FORMAT('.$this->table.'.tanggal, "%Y%m%d"),'.$this->table.'.id) as kode_unik, '.$this->table.'.nomor, barang.nama as nama_barang,barang.kib');
		$this->db->where('kode_skpd', $this->session_login['skpd_session']);
		$this->db->join('barang','barang.kode='.$this->table.'.kode_barang','left');

		$this->db->where('status', 1);
		$kib = $this->input->get('kib');
		if ($kib) {
			$this->db->where('barang.kib', $kib);
		}
		$tahun = $this->input->get('tahun');
		if ($tahun) {
			$this->db->where('year('.$this->table.'.tanggal)', $tahun);
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
			$this->db->or_like('concat(kib,DATE_FORMAT('.$this->table.'.created_at,"%Y%m%d"),'.$this->table.'.id)', $search);
			$this->db->group_end();
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
		$umur	    = $this->input->post('umur');
		$nilai	    = $this->input->post('nilai');
		$info	    = $this->input->post('info');

		$data = array(
			'id_'.$this->module_parent => $id_parent,
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
			$aset_tetap_oleh = $this->db->where('id', $data['id_aset_tetap_oleh'])->get('aset_tetap_oleh')->row();
			$jumlah = $this->input->post('jumlah');
			for ($i=1; $i <= $jumlah; $i++) { 
				$this->db->insert($this->table, $data);
				$data['id'] = $this->db->insert_id();
				$data['kode_skpd'] = $this->session_login['skpd_session'];
				$data['nomor'] = $aset_tetap_oleh->nomor;
				$data['tanggal'] = $aset_tetap_oleh->tanggal;
				$data['uraian'] = $aset_tetap_oleh->uraian;
				$this->db->insert('aset_tetap', $data);
			}
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
			$this->db->where('aset_tetap_oleh_detail.id', $id);
			$this->db->join('barang','barang.kode=aset_tetap_oleh_detail.kode_barang','left');
			$this->db->select('aset_tetap_oleh_detail.*, barang.nama as nama_barang, barang.kib');
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
