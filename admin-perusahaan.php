<?php
session_start();
include "config.php";
requireAdmin();

// --- PROSES HAPUS ---
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    
    // Ambil nama perusahaan untuk log sebelum dihapus
    $res = mysqli_query($conn, "SELECT Nama_perusahaan FROM perusahaan WHERE id_perusahaan=$id");
    $data = mysqli_fetch_assoc($res);
    $nama = $data['Nama_perusahaan'] ?? 'Unknown';

    if (mysqli_query($conn, "DELETE FROM perusahaan WHERE id_perusahaan=$id")) {
        catatLog($conn, "Menghapus perusahaan: $nama"); // Mencatat log
        setFlash('success', 'Data perusahaan berhasil dihapus.');
    }
    redirect('admin-perusahaan.php');
}

// --- PROSES SIMPAN (TAMBAH & EDIT) ---
if (isset($_POST['simpan'])) {
    $id        = (int)$_POST['id'];
    $nama      = clean($_POST['Nama_perusahaan']);
    $alamat    = clean($_POST['Alamat']);
    $bidang    = clean($_POST['bidang']);
    $kapasitas = (int)$_POST['kapasitas'];

    if ($id == 0) {
        // Create Baru
        $sql = "INSERT INTO perusahaan (Nama_perusahaan, Alamat, bidang, kapasitas) 
                VALUES ('$nama', '$alamat', '$bidang', '$kapasitas')";
        $aksi = "Menambah perusahaan baru: $nama";
    } else {
        // Update Data
        $sql = "UPDATE perusahaan SET 
                Nama_perusahaan='$nama', 
                Alamat='$alamat', 
                bidang='$bidang', 
                kapasitas='$kapasitas' 
                WHERE id_perusahaan=$id";
        $aksi = "Mengubah data perusahaan: $nama";
    }

    if (mysqli_query($conn, $sql)) {
        catatLog($conn, $aksi); // Pastikan log tercatat
        setFlash('success', 'Data berhasil disimpan.');
    } else {
        setFlash('error', 'Gagal menyimpan data.');
    }
    redirect('admin-perusahaan.php');
}

$rows = mysqli_query($conn, "SELECT * FROM perusahaan ORDER BY id_perusahaan DESC");
include '_header_admin.php';
?>
<div class="page-header">
  <h2><i class="fas fa-building"></i> Data Perusahaan</h2>
  <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal_perusahaan').classList.add('active')">
    <i class="fas fa-plus"></i> Tambah
  </button>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>#</th><th>Nama Perusahaan</th><th>Alamat</th><th>Bidang</th><th>Kapasitas</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $no=1; while($row=mysqli_fetch_assoc($rows)): ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo htmlspecialchars($row['Nama_perusahaan']??'-');?></td><td><?php echo htmlspecialchars($row['Alamat']??'-');?></td><td><?php echo htmlspecialchars($row['bidang']??'-');?></td><td><?php echo htmlspecialchars($row['kapasitas']??'-');?></td>
        <td style="display:flex;gap:6px;">
          <a href="?hapus=<?php echo $row['id_perusahaan'];?>" class="btn btn-danger btn-sm"
             onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal-overlay" id="modal_perusahaan">
  <div class="modal">
    <div class="modal-header">
      <h3><i class="fas fa-building" style="margin-right:8px;color:#94a3b8;"></i> Tambah Data Perusahaan</h3>
      <button class="modal-close" onclick="document.getElementById('modal_perusahaan').classList.remove('active')"><i class="fas fa-times"></i></button>
    </div>
    <form method="POST">
      <input type="hidden" name="id" value="0"/>
      
      <div class="form-group"><label>Nama Perusahaan</label>
        <input type="text" name="Nama_perusahaan" class="form-control" placeholder="Nama perusahaan"/>
      </div>
      <div class="form-group"><label>Alamat</label>
        <input type="text" name="Alamat" class="form-control" placeholder="Alamat lengkap"/>
      </div>
      <div class="form-group"><label>Bidang Usaha</label>
        <input type="text" name="bidang" class="form-control" placeholder="IT, Networking, dsb."/>
      </div>
      <div class="form-group"><label>Kapasitas PKL</label>
        <input type="number" name="kapasitas" class="form-control" placeholder="0"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('modal_perusahaan').classList.remove('active')">Batal</button>
        <button type="submit" name="simpan" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php include '_footer_admin.php'; ?>
