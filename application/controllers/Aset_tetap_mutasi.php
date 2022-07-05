<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_tetap_mutasi extends MY_Controller {

	private $limit = 15;
	private $table = 'aset_tetap_mutasi';
	public $module = 'aset_tetap_mutasi';
	public $title = 'MUTASI ASET TETAP';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->select($this->table.'.*,b1.nama as nama_barang_lama,b2.nama as nama_barang_baru,b1.kib as kib_lama,b2.kib as kib_baru, s1.nama as nama_skpd_lama, s2.nama as nama_skpd_baru, concat(DATE_FORMAT(aset_tetap.tanggal,"%Y%m%d"),aset_tetap.id) as kode_unik');
		$this->db->join('aset_tetap', 'aset_tetap.id='.$this->table.'.id_aset_tetap', 'left');
		$this->db->join('barang b1', 'b1.kode='.$this->table.'.kode_barang_lama', 'left');
		$this->db->join('barang b2', 'b2.kode='.$this->table.'.kode_barang_baru', 'left');
		$this->db->join('skpd s1', 's1.kode='.$this->table.'.kode_skpd_lama', 'left');
		$this->db->join('skpd s2', 's2.kode='.$this->table.'.kode_skpd_baru', 'left');

		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('b1.kode', $search);
			$this->db->or_like('b1.barang', $search);
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

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('id_aset_tetap', 'Kode Unik', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('kode_barang_lama', 'Kode Barang Lama', 'trim|required');
		$this->form_validation->set_rules('kode_barang_baru', 'Kode Barang Baru', 'trim|required');
		$this->form_validation->set_rules('kode_skpd_lama', 'Kode SKPD Lama', 'trim|required');
		$this->form_validation->set_rules('kode_skpd_baru', 'Kode SKPD Baru', 'trim|required');
	}
	private function _set_data($type = 'add')
	{
		$id_aset_tetap	= $this->input->post('id_aset_tetap');
		$tanggal	= $this->input->post('tanggal');
		$kode_skpd_lama	= $this->input->post('kode_skpd_lama');
		$kode_barang_lama	= $this->input->post('kode_barang_lama');
		$kode_skpd_baru	= $this->input->post('kode_skpd_baru');
		$kode_barang_baru	= $this->input->post('kode_barang_baru');

		$data = array(
			'id_aset_tetap' => $id_aset_tetap,
			'tanggal' => format_ymd($tanggal),
			'kode_skpd_lama' => $kode_skpd_lama,
			'kode_barang_lama' => $kode_barang_lama,
			'kode_skpd_baru' => $kode_skpd_baru,
			'kode_barang_baru' => $kode_barang_baru,
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

			$this->db->update('aset_tetap', [
				'kode_skpd'=>$data['kode_skpd_baru'],
				'kode_barang'=>$data['kode_barang_baru'],
			], ['id'=>$data['id_aset_tetap']]);

			$this->db->trans_complete();
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
			$this->db->select($this->table.'.*,b1.nama as nama_barang_lama,b2.nama as nama_barang_baru,b1.kib as kib_lama,b2.kib as kib_baru, s1.nama as nama_skpd_lama, s2.nama as nama_skpd_baru, concat(DATE_FORMAT(aset_tetap.tanggal,"%Y%m%d"),aset_tetap.id) as kode_unik');
			$this->db->join('aset_tetap', 'aset_tetap.id='.$this->table.'.id_aset_tetap', 'left');
			$this->db->join('barang b1', 'b1.kode='.$this->table.'.kode_barang_lama', 'left');
			$this->db->join('barang b2', 'b2.kode='.$this->table.'.kode_barang_baru', 'left');
			$this->db->join('skpd s1', 's1.kode='.$this->table.'.kode_skpd_lama', 'left');
			$this->db->join('skpd s2', 's2.kode='.$this->table.'.kode_skpd_baru', 'left');
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
			$this->db->trans_start();
			$before = $this->db->where('id', $id)->get($this->table)->row();
			$this->db->update('aset_tetap', [
				'kode_skpd'=>$before->kode_skpd_lama,
				'kode_barang'=>$before->kode_barang_lama,
			], ['id'=>$before->id_aset_tetap]);
			$this->db->update($this->table, $data, ['id'=>$id]);
			$this->db->update('aset_tetap', [
				'kode_skpd'=>$data['kode_skpd_baru'],
				'kode_barang'=>$data['kode_barang_baru'],
			], ['id'=>$data['id_aset_tetap']]);
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
			$this->db->update('aset_tetap', [
				'kode_skpd'=>$before->kode_skpd_lama,
				'kode_barang'=>$before->kode_barang_lama,
			], ['id'=>$before->id_aset_tetap]);
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

}
