<?php
session_start();
include "config.php";
requireAdmin();
$active_page = 'walikelas';
$page_title  = 'Wali Kelas';

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM walikelas WHERE id_walikelas=$id");
    setFlash('success','Data berhasil dihapus.'); redirect('admin-walikelas.php');
}

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['simpan'])) {
    $cols_val = [];
    $sets     = [];
    $id = (int)($_POST['id']??0);
    $Nama_wakel = clean($_POST["Nama_wakel"]??"");
    $Alamat = clean($_POST["Alamat"]??"");
    $Agama_wakel = clean($_POST["Agama_wakel"]??"");
    $No_kontak = clean($_POST["No_kontak"]??"");

    if ($id) {
        mysqli_query($conn, "UPDATE `walikelas` SET `Nama_wakel`='$Nama_wakel',`Alamat`='$Alamat',`Agama_wakel`='$Agama_wakel',`No_kontak`='$No_kontak' WHERE `id_walikelas`=$id");
        setFlash('success','Data berhasil diperbarui.');
    } else {
        mysqli_query($conn, "INSERT INTO `walikelas` (`Nama_wakel`,`Alamat`,`Agama_wakel`,`No_kontak`) VALUES ('$Nama_wakel','$Alamat','$Agama_wakel','$No_kontak')");
        setFlash('success','Data baru berhasil ditambahkan.');
    }
    redirect('admin-walikelas.php');
}


$rows = mysqli_query($conn, "SELECT * FROM walikelas ORDER BY id_walikelas DESC");
include '_header_admin.php';
?>
<div class="page-header">
  <h2><i class="fas fa-user-tie"></i> Wali Kelas</h2>
  <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal_walikelas').classList.add('active')">
    <i class="fas fa-plus"></i> Tambah
  </button>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>#</th><th>Nama Wali Kelas</th><th>Agama</th><th>No. Kontak</th><th>Alamat</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $no=1; while($row=mysqli_fetch_assoc($rows)): ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo htmlspecialchars($row['Nama_wakel']??'-');?></td><td><?php echo htmlspecialchars($row['Agama_wakel']??'-');?></td><td><?php echo htmlspecialchars($row['No_kontak']??'-');?></td><td><?php echo htmlspecialchars($row['Alamat']??'-');?></td>
        <td style="display:flex;gap:6px;">
          <a href="?hapus=<?php echo $row['id_walikelas'];?>" class="btn btn-danger btn-sm"
             onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal-overlay" id="modal_walikelas">
  <div class="modal">
    <div class="modal-header">
      <h3><i class="fas fa-user-tie" style="margin-right:8px;color:#94a3b8;"></i> Tambah Wali Kelas</h3>
      <button class="modal-close" onclick="document.getElementById('modal_walikelas').classList.remove('active')"><i class="fas fa-times"></i></button>
    </div>
    <form method="POST">
      <input type="hidden" name="id" value="0"/>
      
      <div class="form-group"><label>Nama Wali Kelas</label>
        <input type="text" name="Nama_wakel" class="form-control" placeholder="Nama lengkap"/>
      </div>
      <div class="form-group"><label>Alamat</label>
        <input type="text" name="Alamat" class="form-control" placeholder="Alamat"/>
      </div>
      <div class="form-group"><label>Agama</label>
        <input type="text" name="Agama_wakel" class="form-control" placeholder="Islam, Kristen, dll."/>
      </div>
      <div class="form-group"><label>No. Kontak</label>
        <input type="text" name="No_kontak" class="form-control" placeholder="08xx"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('modal_walikelas').classList.remove('active')">Batal</button>
        <button type="submit" name="simpan" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php include '_footer_admin.php'; ?>
