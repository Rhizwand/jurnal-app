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
    $data['title'] = 'Login';
    $this->load->view('auth-template/header', $data);
    $this->load->view('auth/index');
    $this->load->view('auth-template/footer');
  }
  public function register()
  {
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
}
