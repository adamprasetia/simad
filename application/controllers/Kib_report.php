<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kib_report extends MY_Controller {

    public $module = 'kib_report';
    public $title = 'Rekap KIB';

	function __construct()
   	{
    	parent::__construct();
   	}
	public function index()
	{
		$data['script'] = $this->load->view('script/'.$this->module.'_script', '', true);
		$data['content'] = $this->load->view('contents/form_'.$this->module.'_view', [
			'action'=> base_url('kib_report/show')
		], true);
		$this->load->view('template_view',$data);
	}
	public function show()
	{
        $format = $this->input->get('format');

        $this->db->select('a.kode_skpd');
        $this->db->select("s.nama as nama_skpd");
        $this->db->select("sum(if(b.kib='01',a.nilai,0)) as total_a");
        $this->db->select("sum(if(b.kib='02',a.nilai,0)) as total_b");
        $this->db->select("sum(if(b.kib='03',a.nilai,0)) as total_c");
        $this->db->select("sum(if(b.kib='04',a.nilai,0)) as total_d");
        $this->db->select("sum(if(b.kib='05',a.nilai,0)) as total_e");
        $this->db->select("sum(if(b.kib='06',a.nilai,0)) as total_f");
        $this->db->select("sum(a.nilai) as total_all");
        $this->db->from('aset_tetap a');
        $this->db->join('barang b','a.kode_barang=b.kode','left');
        $this->db->join('skpd s','a.kode_skpd=s.kode','left');
        $this->db->group_by('a.kode_skpd');
        $content['data'] = $this->db->get()->result();

        if($format=='excel'){
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=kartu-inventaris-$kib.xls");
		}else if($format=='doc'){
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-word");
			header("Content-Disposition: attachment; filename=kartu-inventaris-$kib.doc");
		}
		$this->load->view('reports/kib_report', $content);

	}

}
