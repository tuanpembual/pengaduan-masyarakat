<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		is_logged_in();
		if ($this->session->userdata('level') != 'superadmin') :
			redirect('Auth/BlockedController');
		endif;

        $this->load->model('Admin_m');
    }

	public function index()
	{
		$data['title'] 	    = 'Tambah Admin';
		$data['data_admin'] = $this->Admin_m->get_all()->result_array();

		$this->form_validation->set_rules('nama','Nama','trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username','Username','trim|required|alpha_numeric_spaces|callback_username_check');
		$this->form_validation->set_rules('password','Password','trim|required|alpha_numeric_spaces|min_length[6]|max_length[15]');

		if ($this->form_validation->run() == FALSE) :
			$this->load->view('_part/backend_head', $data);
			$this->load->view('_part/backend_sidebar_v');
			$this->load->view('_part/backend_topbar_v');
			$this->load->view('admin/admin');
			$this->load->view('_part/backend_footer_v');
			$this->load->view('_part/backend_foot');
		else :
			$params = [
				'nama_admin'	 => htmlspecialchars($this->input->post('nama',TRUE)),
				'username_admin' => htmlspecialchars($this->input->post('username',TRUE)),
				'password_admin' => password_hash(htmlspecialchars($this->input->post('password',TRUE)), PASSWORD_DEFAULT),
			];

			$response = $this->Admin_m->create($params);

			if ($response) :
				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert"> Buat akun admin berhasil </div>');
			else :
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert"> Buat akun admin gagal! </div>');
			endif;

			redirect('Admin/AdminController');
		endif;
	}

	public function edit($id)
{
		$id_admin = htmlspecialchars($id); // id petugas
		$cek_data = $this->db->get_where('admin',['id_admin' => $id_admin])->row_array();

		if ( ! empty($cek_data)) :

			$data['title'] = 'Edit Admin';
			$data['admin'] = $cek_data;

			$this->form_validation->set_rules('nama','Nama','trim|required|alpha_numeric_spaces');
			$this->form_validation->set_rules('password', 'Password','trim|alpha_numeric_spaces|min_length[6]|max_length[15]');

			if ($this->form_validation->run() == FALSE) :
				$this->load->view('_part/backend_head', $data);
				$this->load->view('_part/backend_sidebar_v');
				$this->load->view('_part/backend_topbar_v');
				$this->load->view('admin/edit_admin');
				$this->load->view('_part/backend_footer_v');
				$this->load->view('_part/backend_foot');
			else :
			
				$password = htmlspecialchars($this->input->post('password', TRUE)); 
				$params   = [
					'id'       => $id_admin,
					'nama'     => htmlspecialchars($this->input->post('nama', TRUE)),
					'password' => $password ? password_hash($password, PASSWORD_DEFAULT) : $cek_data['password_admin'],
				];

				$response = $this->Admin_m->update($params);

				if ($response) :
					$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert"> Akun admin berhasil di edit </div>');

					redirect('Admin/AdminController');
				else :
					$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert"> Akun admin gagal di edit! </div>');

					redirect('Admin/AdminController');
				endif;

			endif;

		else :
			$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert"> Data tidak ada </div>');

			redirect('Admin/AdminController');
		endif;
	}

	public function delete($id) 
	{
		$id_admin = htmlspecialchars($id);
		$cek_data = $this->db->get_where('admin', ['id_admin' => $id_admin])->row_array();

		if ( !empty($cek_data) ) :
			$response = $this->db->delete('admin', ['id_admin' => $id_admin]);

			if ( $response ) :
				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert"> Akun berhasil dihapus ! </div>');
			else : 
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert"> Akun gagal dihapus ! </div>');
			endif;
		else :
			$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert"> Data tidak ditemukan </div>');
		endif;

		redirect('Admin/AdminController');
	}

	public function username_check($str = NULL)
	{
		if (!empty($str)) :
			$masyarakat = $this->db->get_where('masyarakat',['username' => $str])->row_array();
			$petugas    = $this->db->get_where('petugas',['username_petugas' => $str])->row_array();
			$admin      = $this->db->get_where('admin', ['username_admin' => $str])->row_array();

			if ($masyarakat == true || $petugas == true || $admin == true) :

				$this->form_validation->set_message('username_check', 'Username ini sudah terdaftar ada.');

				return false;
			else :
				return true;
			endif;
		else :
			$this->form_validation->set_message('username_check', 'Inputan Kosong');

			return false;
		endif;
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/Admin/DashboardController.php */
