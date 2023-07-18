<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		is_logged_in();
	}

	// List all your items
	public function index()
	{
    	$data['title'] = 'Profile';

    	$masyarakat = $this->db->get_where('masyarakat',['username' => $this->session->userdata('username')])->row_array();
		$petugas    = $this->db->get_where('petugas', ['username_petugas' => $this->session->userdata('username')])->row_array();
		$admin      = $this->db->get_where('admin', ['username_admin' => $this->session->userdata('username')])->row_array();

		$detail_masyarakat = [];
		if($masyarakat) {
			$detail_masyarakat = $this->db->get_where('masyarakat_detail', ['nik_masyarakat' => $masyarakat['nik_masyarakat']])->row_array();
			$masyarakat = array_merge($masyarakat, $detail_masyarakat);
		}

		if ($masyarakat == TRUE) :
			$data['user'] = $masyarakat;
		elseif ($petugas == TRUE) :
			$data['user'] = $petugas;
		elseif ($admin == TRUE) :
			$data['user'] = $admin;
		endif;

        $this->load->view('_part/backend_head', $data);
        $this->load->view('_part/backend_sidebar_v');
        $this->load->view('_part/backend_topbar_v');
        $this->load->view('user/profile');
        $this->load->view('_part/backend_footer_v');
        $this->load->view('_part/backend_foot');
	}
}

/* End of file ProfileController.php */
/* Location: ./application/controllers/User/ProfileController.php */
