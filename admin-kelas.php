<?php

session_start();
include "config.php";
requireAdmin();
$active_page = 'kelas';
$page_title  = 'Data Kelas';

// --- PROSES HAPUS ---
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $res = mysqli_query($conn, "SELECT Kelas FROM kelas WHERE id_kelas=$id");
    $nama = mysqli_fetch_assoc($res)['Kelas'] ?? 'Unknown';

    if (mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas=$id")) {
        catatLog($conn, "Menghapus kelas: $nama");
        setFlash('success','Data kelas berhasil dihapus.'); 
    }
    redirect('admin-kelas.php');
}

// --- PROSES SIMPAN ---
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['simpan'])) {
    $id = (int)($_POST['id']??0);
    $Kelas = clean($_POST["Kelas"]);
    $Jurusan = clean($_POST["Jurusan"]);
    $id_walikelas = (int)$_POST["id_walikelas"];

    if ($id == 0) {
        $sql = "INSERT INTO `kelas` (`Kelas`,`Jurusan`,`id_walikelas`) VALUES ('$Kelas','$Jurusan',$id_walikelas)";
        $msg = "Menambah kelas baru: $Kelas";
    } else {
        $sql = "UPDATE `kelas` SET `Kelas`='$Kelas', `Jurusan`='$Jurusan', `id_walikelas`=$id_walikelas WHERE `id_kelas`=$id";
        $msg = "Mengubah data kelas: $Kelas";
    }

    if (mysqli_query($conn, $sql)) {
        catatLog($conn, $msg);
        setFlash('success', 'Data berhasil disimpan.');
    }
    redirect('admin-kelas.php');
}


$wk_opt  = mysqli_query($conn,'SELECT * FROM walikelas ORDER BY Nama_wakel');

$rows = mysqli_query($conn, "SELECT k.*,w.Nama_wakel FROM kelas k LEFT JOIN walikelas w ON k.id_walikelas=w.id_walikelas ORDER BY k.id_kelas DESC");
include '_header_admin.php';
?>
<div class="page-header">
  <h2><i class="fas fa-school"></i> Data Kelas</h2>
  <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal_kelas').classList.add('active')">
    <i class="fas fa-plus"></i> Tambah
  </button>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>#</th><th>Kelas</th><th>Jurusan</th><th>Wali Kelas</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $no=1; while($row=mysqli_fetch_assoc($rows)): ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo htmlspecialchars($row['Kelas']??'-');?></td><td><?php echo htmlspecialchars($row['Jurusan']??'-');?></td><td><?php echo htmlspecialchars($row['Nama_wakel']??'-');?></td>
        <td style="display:flex;gap:6px;">
          <a href="?hapus=<?php echo $row['id_kelas'];?>" class="btn btn-danger btn-sm"
             onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal-overlay" id="modal_kelas">
  <div class="modal">
    <div class="modal-header">
      <h3><i class="fas fa-school" style="margin-right:8px;color:#94a3b8;"></i> Tambah Data Kelas</h3>
      <button class="modal-close" onclick="document.getElementById('modal_kelas').classList.remove('active')"><i class="fas fa-times"></i></button>
    </div>
    <form method="POST">
      <input type="hidden" name="id" value="0"/>
      
      <div class="form-group"><label>Nama Kelas</label>
        <input type="text" name="Kelas" class="form-control" placeholder="XII RPL 1"/>
      </div>
      <div class="form-group"><label>Jurusan</label>
        <input type="text" name="Jurusan" class="form-control" placeholder="Rekayasa Perangkat Lunak"/>
      </div>
      <div class="form-group"><label>Wali Kelas</label>
        <select name="id_walikelas" class="form-control">
          <?php while($rw=mysqli_fetch_assoc($wk_opt)): ?>
          <option value="<?php echo $rw['id_walikelas'];?>"><?php echo htmlspecialchars($rw['Nama_wakel']);?></option>
          <?php endwhile;?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('modal_kelas').classList.remove('active')">Batal</button>
        <button type="submit" name="simpan" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php include '_footer_admin.php'; ?>
