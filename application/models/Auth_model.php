<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

  public function inser_user()
  {
    $data = [
      'username' => htmlspecialchars($this->input->post('username', true)),
      'email' => htmlspecialchars($this->input->post('email', true)),
      'image' => 'default.jpg',
      'password' => password_hash($this->input->post('password1', true), PASSWORD_DEFAULT),
      'is_active' => 1,
      'role_id' => 2,
      'date_created' => time()
    ];
    $this->db->insert('user', $data);
  }
}
