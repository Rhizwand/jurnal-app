<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function index()
  {
    $data['title'] = 'My Profile';
    load_templates_view('user/index', $data);
  }
}
