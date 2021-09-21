        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <button class="btn btn-primary tambah" data-toggle="modal" data-target="#formModal" data-baseurl="<?= base_url() ?>">Tambah Data</button>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col">
              <table class="table-bordered table table-sm">
                <thead>
                  <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Bukti</th>
                    <th scope="col">Jurnal</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Nama Akun</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Kredit</th>
                    <th scope="col">Lainnya</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $user_id = $this->session->userdata('user_id');
                  $refs = $this->db->query("SELECT kode_akun FROM daftar_akun WHERE user_id = $user_id")->result_array();
                  $jumlahDebit = 0;
                  $jumlahKredit = 0;
                  foreach ($akun as $a) :
                    $this->db->select('nama_akun');
                    $this->db->where(["user_id" => $user_id, "kode_akun" => $a['ref']]);
                    $nama_akun = $this->db->get('daftar_akun')->row_array()['nama_akun'];
                  ?>
                    <tr>
                      <td scope="row"><?= $a['tanggal'] ?></td>
                      <td><?= $a['bukti'] ?></td>
                      <td><?= $a['jurnal'] ?></td>
                      <td><?= $a['keterangan'] ?></td>
                      <?php if ($a["kredit"] != 0) : ?>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $nama_akun ?></td>
                      <?php else : ?>
                        <td><?= $nama_akun ?></td>
                      <?php endif; ?>
                      <td>
                        <?php
                        if ($a["debit"] == 0) {
                          echo '-';
                        } else {
                          echo number_format($a["debit"], 0, ',', '.');
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($a["kredit"] == 0) {
                          echo '-';
                        } else {
                          echo number_format($a["kredit"], 0, ',', '.');
                        }
                        ?>
                      </td>
                      <td>
                        <abbr title="Edit"><a href="<?= base_url('jurnal/edit/') . $a['id'] ?>" class="btn badge badge-success modalEdit" data-toggle="modal" data-target="#editModal" data-id="<?= $a['id'] ?>" data-url="<?= base_url(); ?>"><i class="fas fa-edit"></i></a></abbr>
                        <abbr title="Delete"><a href="<?= base_url('jurnal/delete/') . $a['id'] ?>" class="btn badge badge-danger" onclick="return confirm('ini akan menghapus data');"><i class="fas fa-trash-alt"></i></a></abbr>
                      </td>
                      <?php
                      $jumlahDebit += $a["debit"];
                      $jumlahKredit += $a["kredit"];
                      ?>
                    </tr>
                  <?php endforeach; ?>
                  <tr>
                    <th colspan="5" align="center">Jumlah</th>
                    <td><?= number_format($jumlahDebit, 0, ',', '.')  ?></td>
                    <td><?= number_format($jumlahKredit, 0, ',', '.')  ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Page Heading -->

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Modal Tambah Data-->
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="" method="POST">
                <div class="modal-body">
                  <div class="counter">
                    <span class=" badge btn badge-primary d-inline-block" id="kurang">-</span>
                    <input readonly class="p-2 d-inline-block" id="jumlah_baris"></input>
                    <span class=" badge btn badge-primary d-inline-block" id="tambah">+</span>
                  </div>
                  <table class="table table-borderless table-sm">
                    <tbody id="form-row">
                      <tr>
                        <div class="row">
                          <th class="col-md-1">Tanggal</th>
                          <th class="col-md-1">Bukti</th>
                          <th class="col-md-1">Jurnal</th>
                          <th class="col-md-3">Keterangan</th>
                          <th class="col-md-1">Ref</th>
                          <th class="col-md-1">Tambah/Kurang</th>
                          <th class="col-md-2">Nominal</th>
                        </div>
                      </tr>
                      <tr class="formel">
                        <div class="row">
                          <td>
                            <input type="date" class="form-control tanggal" style="width: 170px;">
                          </td>
                          <td>
                            <input type="text" class="form-control bukti">
                          </td>
                          <td>
                            <select class="custom-select jurnal" style="width: 132px;">
                              <option value="Umum" selected>Umum</option>
                              <option value="Penyesuaian">Penyesuaian</option>
                              <option value="Penutup">Penutup</option>
                            </select>

                          </td>
                          <td>
                            <input type="text" class="form-control keterangan">
                          </td>
                          <td>
                            <select class="custom-select ref">
                              <?php foreach ($refs as $ref) : ?>
                                <option class="kode_akun" value="<?= $ref['kode_akun'] ?>"><?= $ref['kode_akun'] ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                          <td>
                            <select class="custom-select tambah_kurang">
                              <option value="Tambah" selected>Tambah</option>
                              <option value="Kurang">Kurang</option>
                            </select>
                          </td>
                          <td>
                            <input type="number" class="form-control nominal">
                          </td>
                        </div>
                      </tr>
                    </tbody>
                  </table>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="tambahkan">Tambahkan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal Edit Data-->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-borderless table-sm">
                  <tr>
                    <div class="row">
                      <th class="col-md-1">Tanggal</th>
                      <th class="col-md-1">Bukti</th>
                      <th class="col-md-1">Jurnal</th>
                      <th class="col-md-3">Keterangan</th>
                      <th class="col-md-1">Ref</th>
                      <th class="col-md-1">Tambah/Kurang</th>
                      <th class="col-md-2">Nominal</th>
                    </div>
                  </tr>
                  <tr class="formel">
                    <form action="jurnal/saveEdit" method="POST">
                      <div class="row">
                        <input type="hidden" name="id" id="id">
                        <td>
                          <input type="date" class="form-control tanggal" name="tanggal" id="tanggal" style="width: 170px;">
                        </td>
                        <td>
                          <input type="text" class="form-control bukti" name="bukti" id="bukti">
                        </td>
                        <td>
                          <select class="custom-select jurnal" id="jurnal" name="jurnal" style="width: 132px;">
                            <option value="Umum" selected>Umum</option>
                            <option value="Penyesuaian">Penyesuaian</option>
                            <option value="Penutup">Penutup</option>
                          </select>

                        </td>
                        <td>
                          <input type="text" class="form-control keterangan" name="keterangan" id="keterangan">
                        </td>
                        <td>
                          <select class="custom-select ref" id="ref" name="ref">
                            <?php foreach ($refs as $ref) : ?>
                              <option class="kode_akun" value="<?= $ref['kode_akun'] ?>"><?= $ref['kode_akun'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select class="custom-select tambah_kurang" name="tambah_kurang" id="tambah_kurang">
                            <option value="Tambah">Tambah</option>
                            <option value="Kurang">Kurang</option>
                          </select>
                        </td>
                        <td>
                          <input type="number" class="form-control nominal" name="nominal" id="nominal">
                        </td>
                      </div>
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>