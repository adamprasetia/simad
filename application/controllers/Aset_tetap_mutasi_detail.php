<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_mutasi_detail extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap_mutasi_detail';
	public $module = 'aset_tetap_mutasi_detail';
	public $module_parent = 'aset_tetap_mutasi';
	public $title = 'MUTASI ASET TETAP';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select($this->table.'.*,b1.kode as kode_barang,b1.nama as nama_barang,b2.nama as nama_barang_baru,b1.kib,b2.kib as kib_baru,aset_tetap.nomor, concat(DATE_FORMAT(aset_tetap_detail.created_at,"%Y%m%d"),aset_tetap_detail.id) as kode_unik');
		$this->db->join('aset_tetap_detail', 'aset_tetap_detail.id='.$this->table.'.id_aset_tetap_detail', 'left');
		$this->db->join('barang b1', 'b1.kode=aset_tetap_detail.kode_barang', 'left');
		$this->db->join('barang b2', 'b2.kode=aset_tetap_mutasi_detail.kode_barang_baru', 'left');
		$this->db->join('aset_tetap', 'aset_tetap.id=aset_tetap_detail.id_aset_tetap', 'left');

		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('b1.kode', $search);
			$this->db->or_like('b1.barang', $search);
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

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('id_aset_tetap_detail', 'Kode Unik', 'trim|required');
		$this->form_validation->set_rules('kode_barang_baru', 'Kode Barang Baru', 'trim|required');
		$this->form_validation->set_rules('kode_skpd_baru', 'Nomor Perolehan Baru', 'trim|required');
		$this->form_validation->set_rules('nomor_baru', 'Nomor Perolehan Baru', 'trim|required');
	}
	private function _set_data($type = 'add')
	{
		$id_parent	= $this->input->post('id_'.$this->module_parent);
		$id_aset_tetap_detail	= $this->input->post('id_aset_tetap_detail');
		$kode_skpd_baru	= $this->input->post('kode_skpd_baru');
		$kode_barang_baru	= $this->input->post('kode_barang_baru');
		$nomor_baru	= $this->input->post('nomor_baru');

		$data = array(
			'id_'.$this->module_parent => $id_parent,
			'id_aset_tetap_detail' => $id_aset_tetap_detail,
			'kode_skpd_baru' => $kode_skpd_baru,
			'kode_barang_baru' => $kode_barang_baru,
			'nomor_baru' => $nomor_baru,
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
			$this->db->trans_start();
			$data = $this->_set_data();
			$this->db->insert($this->table, $data);
			// $nomor_baru = $this->input->post('nomor_baru');
			// $kode_skpd_baru = $this->input->post('kode_skpd_baru');
			// $aset_tetap = $this->db->where('kode_skpd', $kode_skpd_baru)->where('nomor', $nomor_baru)->get('aset_tetap')->row();
			// if(!empty($aset_tetap)){
			// 	$id_aset_tetap_baru = $aset_tetap->id;
			// }else{
			// 	$this->db->insert('aset_tetap', [
			// 		'kode_skpd'=>$data['kode_skpd_baru'],
			// 		'nomor'=>$data['nomor_baru'],
			// 		'tanggal'=>$this->input->post('tanggal'),
			// 		'uraian'=>'Mutasi dari '.$this->session_login['skpd_session'],
			// 		'created_by' => $this->session_login['id'],
			// 		'created_at' => date('Y-m-d H:i:s'),	
			// 	]);
			// 	$id_aset_tetap_baru = $this->db->insert_id();
			// }
	
			// $aset_tetap_detail = $this->db->where('id', $data['id_aset_tetap_detail'])->get('aset_tetap_detail')->row();
			// $this->db->insert('aset_tetap_detail', [
			// 	'id_aset_tetap'=>$id_aset_tetap_baru,
			// 	'kode_barang'=>$data['kode_barang_baru'],
			// 	'umur'=>$aset_tetap_detail->umur,
			// 	'nilai'=>$aset_tetap_detail->nilai,
			// 	'info'=>$aset_tetap_detail->info,
			// 	'info_lain'=>$aset_tetap_detail->info_lain,
			// 	'note'=>'Mutasi dari '.$this->session_login['skpd_session'],
			// 	'created_by' => $this->session_login['id'],
			// 	'created_at' => date('Y-m-d H:i:s'),	
			// ]);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$this->db->insert_id(), 'action'=>'insert', 'message'=>'Data berhasil disimpan');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}
			$this->db->trans_complete();

			echo json_encode($response);
		}
	}

	public function edit($id='')
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$this->db->where($this->table.'.id', $id);
			$this->db->select($this->table.'.*,b1.kode as kode_barang,b1.nama as nama_barang,b2.nama as nama_barang_baru,b1.kib,b2.kib as kib_baru,aset_tetap.nomor, concat(DATE_FORMAT(aset_tetap_detail.created_at,"%Y%m%d"),aset_tetap_detail.id) as kode_unik');
			$this->db->join('aset_tetap_detail', 'aset_tetap_detail.id='.$this->table.'.id_aset_tetap_detail', 'left');
			$this->db->join('barang b1', 'b1.kode=aset_tetap_detail.kode_barang', 'left');
			$this->db->join('barang b2', 'b2.kode=aset_tetap_mutasi_detail.kode_barang_baru', 'left');
			$this->db->join('aset_tetap', 'aset_tetap.id=aset_tetap_detail.id_aset_tetap', 'left');	
			$content['data'] = $this->db->get($this->table)->row();
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
