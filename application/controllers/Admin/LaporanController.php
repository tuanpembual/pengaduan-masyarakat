<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		is_logged_in();
		if ($this->session->userdata('level') == NULL) :
			redirect('Auth/BlockedController');
		endif;

		$this->load->model('Petugas_m');
		$this->load->model('Pengaduan_m');
	}

	// List all your items
	public function index()
	{
		$id_kabupaten    = $this->id_kabupaten();
		$data['title']   = 'Cetak Laporan';
		$data['laporan'] = $this->Pengaduan_m->laporan_pengaduan($id_kabupaten)->result_array();

		$this->load->view('_part/backend_head', $data);
		$this->load->view('_part/backend_sidebar_v');
		$this->load->view('_part/backend_topbar_v');
		$this->load->view('admin/generate_laporan');
		$this->load->view('_part/backend_footer_v');
		$this->load->view('_part/backend_foot');
	}

	public function generate_laporan()
	{
		$id_kabupaten    = $this->id_kabupaten();
		$data['laporan'] = $this->Pengaduan_m->laporan_pengaduan($id_kabupaten)->result_array();

		$this->load->library('pdf');

		$this->pdf->setPaper('A4', 'landscape'); // opsional | default A4
		$this->pdf->filename = "laporan-pengaduan.pdf"; // opsional | default is laporan.pdf
		$this->pdf->load_view('laporan_pdf', $data);
	}

	public function id_kabupaten()
	{
		$username			= $this->session->userdata('username');
		$level				= $this->session->userdata('level');
		$petugas			= $this->Petugas_m->get_petugas_by_username($username)->row();
		$id_petugas		= $petugas ? $petugas->id_petugas : NULL;
		$id_kabupaten	= NULL;

		if($level == 'kabupaten') $id_kabupaten =  $this->Petugas_m->get_petugas_kabupaten($id_petugas)->row()->id_kabupaten;

		return $id_kabupaten;
	}
}

/* End of file LaporanController.php */
/* Location: ./application/controllers/Admin/LaporanController.php */
