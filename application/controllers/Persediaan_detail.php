<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persediaan_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'persediaan_detail';
	public $module = 'persediaan_detail';
	public $module_parent = 'persediaan';
	public $title = 'Perolehan Persediaan';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		if(!empty($this->input->get('popup'))){
			$this->db->select($this->table.'.*, persediaan.nomor');
			$this->db->join('persediaan','persediaan.id='.$this->table.'.id_persediaan','left');
		}
		$metode = $this->input->get('metode');
		if ($metode) {
			$this->db->where('metode', $metode);
		}
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('kode_barang', $search);
			$this->db->or_like('nama_barang', $search);
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
		$this->form_validation->set_rules('metode', 'Metode', 'trim|required');
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
		$this->form_validation->set_rules('masa_berlaku', 'Masa Berlaku', 'trim');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');
		$this->form_validation->set_rules('satuan', 'Satuan', 'trim');
		$this->form_validation->set_rules('nilai', 'Nilai', 'trim');
	}
	
	private function _set_data($type = 'add')
	{
		$id_parent	= $this->input->post('id_'.$this->module_parent);
		$metode	= $this->input->post('metode');
		$kode_barang	= $this->input->post('kode_barang');
		$nama_barang	    = $this->input->post('nama_barang');
		$masa_berlaku	    = $this->input->post('masa_berlaku');
		$jumlah	    = $this->input->post('jumlah');
		$satuan	    = $this->input->post('satuan');
		$nilai	    = $this->input->post('nilai');

		$data = array(
			'id_'.$this->module_parent => $id_parent,
			'metode' => $metode,
			'kode_barang' => $kode_barang,
			'nama_barang' => $nama_barang,
			'masa_berlaku' => format_ymd($masa_berlaku),
			'jumlah' => format_uang($jumlah),
			'satuan' => $satuan,
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
			$content['data'] = $this->db->get($this->table)->row();
			$content['data']->nilai = number_format($content['data']->nilai);
			$content['data']->jumlah = number_format($content['data']->jumlah);
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

	public function api()
	{
		$search = $this->input->get('search');
		$metode = $this->input->get('metode');
		$kode_barang = $this->input->get('kode_barang');
		$tahun = $this->input->get('tahun');
		$this->db->where('b.kode_skpd', $this->session_login['skpd_session']);
		if(!empty($metode)){
			$this->db->where('a.metode', $metode);
		}
		if(!empty($kode_barang)){
			$this->db->where('a.kode_barang', $kode_barang);
		}
		if(!empty($tahun)){
			$this->db->where('year(b.tanggal)', $tahun);
		}
		$this->db->group_start();
		$this->db->like('b.nomor', $search);
		$this->db->group_end();
		$result = $this->db->select('b.id as id,concat(b.nomor," | ",FORMAT(a.jumlah,0)," | ",a.satuan," | ",FORMAT(a.nilai,0)) as text')
		->join('persediaan b','b.id = a.id_persediaan','left')
		->get($this->table.' a', 10, 0)->result_array();
		// echo $this->db->last_query();exit;
		echo json_encode(['results'=>$result]);
	}


}
