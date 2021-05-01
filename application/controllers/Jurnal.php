<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal extends CI_Controller
{
  public function index()
  {
    $data['title'] = "Jurnal";
    load_templates_view('Jurnal/index', $data);
  }

  public function kode_akun()
  {
    $data['title'] = 'Kode Akun';
    load_templates_view('jurnal/kode_akun', $data);
  }

  public function uploadKode()
  {
    $_SESSION['kode'] = $this->input->post('kode');
  }
}
