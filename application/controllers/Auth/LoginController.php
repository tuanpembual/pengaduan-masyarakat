<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	// List all your items
	public function index()
	{
		$data['title'] = 'Login';

		$this->form_validation->set_rules('username','Username','trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('password','Password','trim|required|alpha_numeric_spaces');

		if ($this->form_validation->run() == FALSE) :
			$this->load->view('_part/login_head', $data);
			$this->load->view('login_v');
			$this->load->view('_part/login_footer');
		else :
			$username = htmlspecialchars($this->input->post('username',TRUE));
			$password = htmlspecialchars($this->input->post('password',TRUE));

			$this->cek_login($username, $password);
		endif;
	}

	private function cek_login($username, $password)
	{
		// cek akun di table masyarakat dan petugas berdasarkan username
		$masyarakat = $this->db->get_where('masyarakat',['username' => $username])->row_array();
		$petugas    = $this->db->get_where('petugas',['username_petugas' => $username])->row_array();
		$admin      = $this->db->get_where('admin', ['username_admin' => $username])->row_array();

		if ($masyarakat == TRUE) :
			if (! $masyarakat['is_verified']) :
				// jika akun masyakarat belum di verifikasi admin
				// redirect to login page
				$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert"> Akun belum terverifikasi </div>');
				
				return redirect('Auth/LoginController');
			endif;

			// jika akun masyarakat == TRUE
			// cek password
			if (password_verify($password, $masyarakat['password'])) :
				// jika password benar
				// maka buat session userdata
				$session = [
					'username' 		=> $masyarakat['username'],
				];

				$this->session->set_userdata($session);

				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
					Login berhasil!
					</div>');

				return redirect('User/ProfileController');

			else :
				// password salah
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
					Username atau Password salah!
					</div>');

				return redirect('Auth/LoginController');
			endif;

		elseif ($petugas == TRUE) :
			// jika akun petugas == TRUE
			// cek password

			if (password_verify($password, $petugas['password_petugas'])) :
				// jika password benar
				// maka buat session userdata
				if ($petugas['username_petugas'] == 'admin'):
					$session = [
						'username' => $petugas['username_petugas'],
						'level'	   => 'provinsi',
					];
				else:
					$session = [
						'username' => $petugas['username_petugas'],
						'level'	   => 'kabupaten',
					];
				endif;	

				$this->session->set_userdata($session);
				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert"> Login berhasil! </div>');

				return redirect('User/ProfileController');
			else :
				// jika password salah
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
					Username atau Password salah!
					</div>');

				return redirect('Auth/LoginController');
			endif;
		elseif ($admin == TRUE) : 
			// jika akun admin == TRUE
			// maka buat session userdata
			if (password_verify($password, $admin['password_admin'])) :
				$session = [
					'username' => $admin['username_admin'],
					'level'    => 'superadmin'
				];

				$this->session->set_userdata($session);
				$this->session->set_flashdata('msg', '<div class="alert alert-primary" role="alert"> Login berhasil! </div>');

				return redirect('User/ProfileController');
			else :
				// jika password salah
				$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert"> Username atau Password salah ! </div>');

				return redirect('Auth/LoginController');
			endif;
		else :
		// tidak ada akun yang di temukan
			$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
				Username atau Password salah!
				</div>');

			return redirect('Auth/LoginController');
		endif;
	}
}

/* End of file LoginController.php */
/* Location: ./application/controllers/Auth/LoginController.php */
