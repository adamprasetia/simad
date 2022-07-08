<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_report extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap';
	public $module = 'aset_tetap_report';
	public $title = 'KARTU INVENTARIS';

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
		$data['script'] = $this->load->view('script/'.$this->module.'_script', '', true);
		$data['content'] = $this->load->view('contents/form_'.$this->module.'_view', [
			'action'=> base_url('aset_tetap_report/show')
		], true);
		$this->load->view('template_view',$data);
	}

	public function show(){
        $kib = $this->input->get('kib');
        $format = $this->input->get('format');
		$this->_filter();
		$content['data'] 	= $this->db->get($this->table)->result();
		$lokasi = $this->db->where('kode', $this->session_login['skpd_session'])->get('skpd')->row();
		$content['lokasi'] 	= $lokasi->kode.' / '.$lokasi->nama;

		if($format=='excel'){
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=kartu-inventaris-$kib.xls");
		}else if($format=='doc'){
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-word");
			header("Content-Disposition: attachment; filename=kartu-inventaris-$kib.doc");
		}
		$this->load->view('reports/'.$this->table.'_'.$kib.'_report', $content);
		

	}
}
