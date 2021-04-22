<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Auth_model', 'auth');
  }

  public function index()
  {
    if ($this->session->userdata('email')) {
      redirect('user');
    }
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Login';
      $this->load->view('auth-template/header', $data);
      $this->load->view('auth/index');
      $this->load->view('auth-template/footer');
    } else {
      $this->_login();
    }
  }
  public function register()
  {
    if ($this->session->userdata('email')) {
      redirect('user');
    }
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]|min_length[6]', [
      'min_length' => 'must be at least 6 character',
      'matches' => 'password does not matches'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password1]');
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Register';
      $this->load->view('auth-template/header', $data);
      $this->load->view('auth/register');
      $this->load->view('auth-template/footer');
    } else {
      $this->auth->inser_user();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulations, your account has created. Please Login</div>');
      redirect('auth');
    }
  }

  private function _login()
  {
    $email = $this->input->post('email');
    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    if ($user) {
      if ($user['is_active'] == 1) {
        if (password_verify($this->input->post('password'), $user['password'])) {
          $data = [

            'email' => $email,
            'user_id' => $user['id']
          ];
          $this->session->set_userdata($data);
          redirect('user');
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password</div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been verified</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email has not registered</div>');
      redirect('auth');
    }
  }
  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been loged out</div>');
    redirect('auth');
  }
}
