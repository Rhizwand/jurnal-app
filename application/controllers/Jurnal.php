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
    $data['akun'] = $this->db->get_where('daftar_akun', ['user_id' => $this->session->userdata('user_id')])->result_array();
    $data['title'] = 'Kode Akun';
    load_templates_view('jurnal/kode_akun', $data);
  }

  public function uploadKode()
  {
    // $_SESSION['kode'] = $this->input->post('kode');
    $kode = json_decode($this->input->post('kode'));
    foreach ($kode as $k) {
      $data = [
        "user_id" => $this->session->userdata('user_id'),
        "kode_akun" => $k->kode_akun,
        "nama_akun" => $k->nama_akun,
        "saldo_normal" => $k->saldo_normal
      ];
      $this->db->insert('daftar_akun', $data);
    }
  }

  public function deleteakun()
  {
    $this->db->where('user_id', $this->session->userdata('user_id'));
    $this->db->delete('daftar_akun');
    redirect('jurnal/kode_akun');
  }
}
