<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal extends CI_Controller
{
  public function index()
  {
    $this->db->where('user_id', $this->session->userdata('user_id'));
    $this->db->order_by('jurnal', 'DESC');
    $this->db->order_by('tanggal', 'ASC');
    $this->db->order_by('bukti', 'ASC');
    $this->db->order_by('debit', 'DESC');
    $data['akun'] = $this->db->get('jurnal_app')->result_array();
    $data['title'] = "Jurnal";
    echo $this->input->post('tanggal');
    load_templates_view('jurnal/index', $data);
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
    $datas = [];
    foreach ($kode as $no => $data) {
      $akun = [];
      foreach ($data as $key => $value) {
        array_push($akun, $value);
      }
      $data = [
        "user_id" => $this->session->userdata('user_id'),
        "kode_akun" => $akun[0],
        "nama_akun" => $akun[1],
        "saldo_normal" => $akun[2]
      ];
      $this->db->insert('daftar_akun', $data);
      // var_dump($data);
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
    $user_id = $this->session->userdata('user_id');
    $akun = json_decode($this->input->post('jurnal'));
    for (
      $i = 0;
      $i < count($akun[0]) - 1;
      $i++
    ) {
      $ref = $akun[4][$i];
      $this->db->select('saldo_normal');
      $this->db->where(['user_id' => $user_id, 'kode_akun' => $ref]);
      $saldo_normal = $this->db->get('daftar_akun')->row_array()['saldo_normal'];
      $tambah_kurang = $akun[5][$i];
      $nominal = $akun[6][$i];
      $debit = ($saldo_normal == 'DEBIT' && $tambah_kurang == 'Tambah') || ($saldo_normal == "KREDIT" && $tambah_kurang == "Kurang") ? $nominal : 0;
      $kredit = ($saldo_normal == 'DEBIT' && $tambah_kurang == 'Kurang') || ($saldo_normal == "KREDIT" && $tambah_kurang == "Tambah") ? $nominal : 0;
      $data = [
        "user_id" => $user_id,
        "tanggal" => $akun[0][$i],
        "bukti" => $akun[1][$i],
        "jurnal" => $akun[2][$i],
        "keterangan" => $akun[3][$i],
        "ref" => $ref,
        "tambah_kurang" => $tambah_kurang,
        "nominal" => $nominal,
        "debit" => $debit,
        "kredit" => $kredit
      ];
      $this->db->insert('jurnal_app', $data);
    }
    die;
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

  public function saveEdit()
  {
    $id = $this->input->post('id');
    $data = [
      "id" => $id,
      "user_id" => $this->session->userdata('user_id'),
      "tanggal" => $this->input->post('tanggal'),
      "bukti" => $this->input->post('bukti'),
      "jurnal" => $this->input->post('jurnal'),
      "keterangan" => $this->input->post('keterangan'),
      "ref" => $this->input->post('ref'),
      "tambah_kurang" => $this->input->post('tambah_kurang'),
      "nominal" => $this->input->post('nominal')
    ];

    $this->db->where('id', $id);
    $this->db->update('jurnal_app', $data);
    redirect('jurnal');
  }
}
