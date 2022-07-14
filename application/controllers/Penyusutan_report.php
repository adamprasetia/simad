<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penyusutan_report extends MY_Controller {

    public $module = 'penyusutan_report';
    public $title = 'Rekapitulasi Penyusutan';

	function __construct()
   	{
    	parent::__construct();
   	}
	public function index()
	{
		$data['script'] = $this->load->view('script/'.$this->module.'_script', '', true);
		$data['content'] = $this->load->view('contents/form_'.$this->module.'_view', [
			'action'=> base_url('penyusutan_report/show')
		], true);
		$this->load->view('template_view',$data);
	}
	public function show()
	{
        $format = $this->input->get('format');
        $kib = $this->input->get('kib');
        if(!empty($kib)){
            $this->db->where('b.kib', $kib);
        }
        $this->db->select('a.*, b.nama as nama_barang, year(a.tanggal) as tahun');
		$this->db->join('barang b','a.kode_barang=b.kode','left');
		$this->db->where('a.kode_skpd', $this->session_login['skpd_session']);
        $content['data'] = $this->db->get('aset_tetap a')->result();
        $lokasi = $this->db->where('kode', $this->session_login['skpd_session'])->get('skpd')->row();
		$content['lokasi'] 	= $lokasi->kode.' / '.$lokasi->nama;
		$content['kib'] 	= $kib;

        if($format=='excel'){
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=kartu-inventaris-$kib.xls");
		}else if($format=='doc'){
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-word");
			header("Content-Disposition: attachment; filename=kartu-inventaris-$kib.doc");
		}
		$this->load->view('reports/penyusutan_report', $content);

	}

}
