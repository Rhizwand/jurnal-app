<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal extends CI_Controller
{
  public function index()
  {
    $data['akun'] = $this->db->get_where('jurnal_app', ['user_id' => $this->session->userdata('user_id')])->result_array();
    $data['title'] = "Jurnal";
    echo $this->input->post('tanggal');
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

  public function insert_data()
  {
    $akun = json_decode($this->input->post('jurnal'));
    for (
      $i = 0;
      $i < count($akun[0]) - 1;
      $i++
    ) {
      var_dump($akun[0]);
      $data = [
        "user_id" => $this->session->userdata('user_id'),
        "tanggal" => $akun[0][$i],
        "bukti" => $akun[1][$i],
        "jurnal" => $akun[2][$i],
        "keterangan" => $akun[3][$i],
        "ref" => $akun[4][$i],
        "tambah_kurang" => $akun[5][$i],
        "nominal" => $akun[6][$i]
      ];
      // $this->db->insert('jurnal_app', $data);
    }
  }

  public function delete($id)
  {
    $this->db->where(['id' => $id]);
    $this->db->delete('jurnal_app');
    redirect('jurnal');
  }

  public function edit()
  {
    $id = $this->input->post('id');
    echo json_encode($this->db->get_where('jurnal_app', ['id' => $id])->row_array());
  }
}
