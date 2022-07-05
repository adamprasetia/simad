<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persediaan_oleh_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'persediaan_oleh_detail';
	public $module = 'persediaan_oleh_detail';
	public $module_parent = 'persediaan_oleh';
	public $title = 'Perolehan Persediaan';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select('a.*, b.nama as nama_barang, b.satuan');
		$this->db->join('barang_persediaan b','a.kode_barang=b.kode','left');
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('a.kode_barang', $search);
			$this->db->or_like('b.nama_barang', $search);
			$this->db->group_end();
		}
        $parent = $this->input->get('id_'.$this->module_parent);
		if(!empty($parent)){
			$this->db->where('a.id_'.$this->module_parent, $parent);
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table.' a');
		$this->_filter();
		$content['data'] 	= $this->db->get($this->table.' a', $this->limit, $offset)->result();
		$content['offset'] = $offset;
		$content['paging'] = gen_paging($total,$this->limit);
		$content['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/'.$this->module.'_view', $content, TRUE);

		$this->load->view(!empty($this->input->get('popup'))?'modals/template_view':'template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('metode', 'Metode', 'trim|required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
		$this->form_validation->set_rules('nilai', 'Nilai', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$id_parent	= $this->input->post('id_'.$this->module_parent);
		$kode_barang	= $this->input->post('kode_barang');
		$metode	= $this->input->post('metode');
		$masa_berlaku	= $this->input->post('masa_berlaku');
		$jumlah	    = $this->input->post('jumlah');
		$nilai	    = $this->input->post('nilai');

		$data = array(
			'id_'.$this->module_parent => $id_parent,
			'kode_barang' => $kode_barang,
			'jumlah' => format_uang($jumlah),
			'metode' => $metode,
			'masa_berlaku' => format_ymd($masa_berlaku),
			'nilai' => format_uang($nilai)
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
			$this->db->trans_start();
			$this->db->insert($this->table, $data);

			$persediaan = $this->db->where('kode_skpd', $this->session_login['skpd_session'])->where('kode_barang', $data['kode_barang'])->get('persediaan')->row();
			if(!empty($persediaan)){
				$this->db->where('id', $persediaan->id);
				$this->db->set('stok', 'stok+'.$data['jumlah'], FALSE);
				$this->db->update('persediaan');
			}else{
				$this->db->insert('persediaan',[
					'kode_skpd'=>$this->session_login['skpd_session'],
					'kode_barang'=>$data['kode_barang'],
					'stok'=>$data['jumlah']
				]);
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
			$this->db->where('id', $id);
			$content['data'] = $this->db->get($this->table)->row();
			$barang = $this->db->where('kode', $content['data']->kode_barang)->get('barang_persediaan')->row();
			$content['data']->nilai = number_format($content['data']->nilai);
			$content['data']->jumlah = number_format($content['data']->jumlah);
			$content['data']->nama_barang = $barang->nama;
			$content['data']->satuan = $barang->satuan;
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
			$before = $this->db->where('id', $id)->get($this->table)->row();
			$selisih = $data['jumlah'] - $before->jumlah;
			$persediaan = $this->db->where('kode_skpd', $this->session_login['skpd_session'])->where('kode_barang', $data['kode_barang'])->get('persediaan')->row();
			if(!empty($persediaan)){
				$this->db->where('id', $persediaan->id);
				$this->db->set('stok', 'stok+'.$selisih, FALSE);
				$this->db->update('persediaan');
			}
			$this->db->update($this->table, $data, ['id'=>$id]);
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
			$before = $this->db->where('id', $id)->get($this->table)->row();
			if(!empty($before)){
				$this->db->where('kode_skpd', $this->session_login['skpd_session']);
				$this->db->where('kode_barang', $before->kode_barang);
				$this->db->set('stok', 'stok-'.$before->jumlah, FALSE);
				$this->db->update('persediaan');
			}

			$this->db->delete($this->table, ['id'=>$id]);
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
