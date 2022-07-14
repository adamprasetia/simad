<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persediaan_report extends MY_Controller {

    public $module = 'persediaan_report';
    public $title = 'Daftar Persediaan';

	function __construct()
   	{
    	parent::__construct();
   	}
	public function index()
	{
		$data['script'] = $this->load->view('script/'.$this->module.'_script', '', true);
		$data['content'] = $this->load->view('contents/form_'.$this->module.'_view', [
			'action'=> base_url('persediaan_report/show')
		], true);
		$this->load->view('template_view',$data);
	}
	public function show()
	{
        $format = $this->input->get('format');
        $this->db->select('a.*, b.nama as nama_barang,b.satuan as satuan');
		$this->db->join('barang_persediaan b','a.kode_barang=b.kode','left');
		$this->db->where('a.kode_skpd', $this->session_login['skpd_session']);
        $content['data'] = $this->db->get('persediaan a')->result();
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
		$this->load->view('reports/persediaan_report', $content);

	}

}
