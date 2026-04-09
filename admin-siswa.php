<?php
session_start();
include 'config.php';
requireAdmin();
$active_page='siswa';
$page_title='Data Siswa';
include '_header_admin.php';


if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $res = mysqli_query($conn, "SELECT Nama_siswa FROM siswa WHERE id_siswa=$id");
    $nama = mysqli_fetch_assoc($res)['Nama_siswa'] ?? 'Unknown';

    if (mysqli_query($conn, "DELETE FROM siswa WHERE id_siswa=$id")) {
        catatLog($conn, "Menghapus siswa: $nama");
        setFlash('success','Data siswa berhasil dihapus.'); 
    }
    redirect('admin-siswa.php');
}

// --- PROSES SIMPAN ---
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['simpan_siswa'])) {
    $id   = (int)($_POST['id']??0);
    $nis  = clean($_POST['nis']); 
    $nama = clean($_POST['nama']);
    $jk   = clean($_POST['jk']);  
    $agm  = clean($_POST['agama']);
    $ttl  = clean($_POST['ttl']); 
    $hp   = clean($_POST['hp']);
    $alm  = clean($_POST['alamat']); 
    $gol  = clean($_POST['goldar']);
    $kls  = (int)$_POST['id_kelas']; 
    $prs  = (int)$_POST['id_perusahaan'];
    $pmb  = (int)$_POST['id_pembimbing']; 
    $wkl  = (int)$_POST['id_walikelas'];

    if ($id == 0) {
        $sql = "INSERT INTO siswa (Nis_siswa, Nama_siswa, Jenis_kelamin, Agama_siswa, TTL, NO_Kontak, Alamat_siswa, Goldar, id_kelas, id_perusahaan, id_pembimbing, id_walikelas) 
                VALUES ('$nis','$nama','$jk','$agm','$ttl','$hp','$alm','$gol',$kls,$prs,$pmb,$wkl)";
        $msg = "Menambah siswa baru: $nama";
    } else {
        $sql = "UPDATE siswa SET Nis_siswa='$nis', Nama_siswa='$nama', Jenis_kelamin='$jk', Agama_siswa='$agm', 
                TTL='$ttl', NO_Kontak='$hp', Alamat_siswa='$alm', Goldar='$gol', id_kelas=$kls, 
                id_perusahaan=$prs, id_pembimbing=$pmb, id_walikelas=$wkl WHERE id_siswa=$id";
        $msg = "Mengubah data siswa: $nama";
    }

    if (mysqli_query($conn, $sql)) {
        catatLog($conn, $msg);
        setFlash('success', 'Data siswa berhasil disimpan.');
    }
    redirect('admin-siswa.php');
}

// <!-- if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['simpan_siswa'])) {
//     $id   = (int)($_POST['id']??0);
//     $nis  = clean($_POST['nis']); $nama = clean($_POST['nama']);
//     $jk   = clean($_POST['jk']);  $agm  = clean($_POST['agama']);
//     $ttl  = clean($_POST['ttl']); $hp   = clean($_POST['hp']);
//     $alm  = clean($_POST['alamat']); $gol = clean($_POST['goldar']);
//     $kls  = (int)$_POST['id_kelas']; $prs = (int)$_POST['id_perusahaan'];
//     $pmb  = (int)$_POST['id_pembimbing']; $wkl = (int)$_POST['id_walikelas'];
//     if ($id) {
//         mysqli_query($conn, "UPDATE siswa SET Nis_siswa='$nis',Nama_siswa='$nama',
//             Jenis_kelamin='$jk',Agama_siswa='$agm',TTL='$ttl',NO_Kontak='$hp',
//             Alamat_siswa='$alm',Goldar='$gol',id_kelas=$kls,id_perusahaan=$prs,
//             id_pembimbing=$pmb,id_walikelas=$wkl WHERE id_siswa=$id");
//         setFlash('success','Data siswa diperbarui.');
//     } else {
//         mysqli_query($conn, "INSERT INTO siswa (Nis_siswa,Nama_siswa,Jenis_kelamin,
//             Agama_siswa,TTL,NO_Kontak,Alamat_siswa,Goldar,id_kelas,id_perusahaan,
//             id_pembimbing,id_walikelas) VALUES ('$nis','$nama','$jk','$agm','$ttl',
//             '$hp','$alm','$gol',$kls,$prs,$pmb,$wkl)");
//         setFlash('success','Siswa baru ditambahkan.');
//     }
//     redirect('admin-siswa.php');
// } -->
$search = clean($_GET['s']??'');
$where  = $search ? "WHERE s.Nama_siswa LIKE '%$search%' OR s.Nis_siswa LIKE '%$search%'" : '';
$rows   = mysqli_query($conn, "SELECT s.*,k.Kelas,p.Nama_perusahaan,pb.nama nama_pmb
    FROM siswa s
    LEFT JOIN kelas k ON s.id_kelas=k.id_kelas
    LEFT JOIN perusahaan p ON s.id_perusahaan=p.id_perusahaan
    LEFT JOIN pembimbing_pkl pb ON s.id_pembimbing=pb.id_pembimbing
    $where ORDER BY s.id_siswa DESC");
$kelasList = mysqli_query($conn,"SELECT * FROM kelas ORDER BY Kelas");
$prsList   = mysqli_query($conn,"SELECT * FROM perusahaan ORDER BY Nama_perusahaan");
$pmbList   = mysqli_query($conn,"SELECT * FROM pembimbing_pkl ORDER BY nama");
$wklList   = mysqli_query($conn,"SELECT * FROM walikelas ORDER BY Nama_wakel");
?>
<div class="page-header">
  <h2><i class="fas fa-user-graduate"></i> Data Siswa</h2>
  <button class="btn btn-primary btn-sm" onclick="openModal('modalSiswa')">
    <i class="fas fa-user-plus"></i> Tambah Siswa
  </button>
</div>
<div class="card" style="margin-bottom:16px;">
  <form method="GET" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    <div class="search-bar"><i class="fas fa-search"></i>
      <input type="text" name="s" placeholder="Cari nama / NIS..." value="<?php echo htmlspecialchars($search);?>"/>
    </div>
    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-filter"></i> Cari</button>
    <?php if($search): ?><a href="admin-siswa.php" class="btn btn-sm" style="background:rgba(255,255,255,.06);color:#64748b;">Reset</a><?php endif;?>
  </form>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>#</th><th>NIS</th><th>Nama Siswa</th><th>JK</th><th>Kelas</th><th>Perusahaan</th><th>Pembimbing</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $no=1; while($r=mysqli_fetch_assoc($rows)): ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo htmlspecialchars($r['Nis_siswa']);?></td>
        <td><i class="fas fa-user-graduate" style="color:#94a3b8;margin-right:7px;"></i><?php echo htmlspecialchars($r['Nama_siswa']);?></td>
        <td><?php echo $r['Jenis_kelamin']==='L'?'<span class="pill pill-blue">L</span>':'<span class="pill pill-purple">P</span>';?></td>
        <td><?php echo htmlspecialchars($r['Kelas']??'-');?></td>
        <td><?php echo htmlspecialchars($r['Nama_perusahaan']??'-');?></td>
        <td><?php echo htmlspecialchars($r['nama_pmb']??'-');?></td>
        <td style="display:flex;gap:6px;">
          <button class="btn btn-warning btn-sm" onclick="editSiswa(<?php
            echo htmlspecialchars(json_encode($r),ENT_QUOTES); ?>)">
            <i class="fas fa-edit"></i>
          </button>
          <a href="?hapus=<?php echo $r['id_siswa'];?>" class="btn btn-danger btn-sm"
             onclick="return confirm('Hapus siswa ini?')"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modalSiswa">
  <div class="modal" style="max-width:620px;">
    <div class="modal-header">
      <h3 id="modalSiswaTitle"><i class="fas fa-user-plus" style="margin-right:8px;color:#94a3b8;"></i> Tambah Siswa</h3>
      <button class="modal-close" onclick="closeModal('modalSiswa')"><i class="fas fa-times"></i></button>
    </div>
    <form method="POST">
      <input type="hidden" name="id" id="s_id" value="0"/>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group"><label>NIS</label><input type="text" name="nis" id="s_nis" class="form-control" required placeholder="NIS Siswa"/></div>
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" id="s_nama" class="form-control" required placeholder="Nama lengkap"/></div>
        <div class="form-group"><label>Jenis Kelamin</label>
          <select name="jk" id="s_jk" class="form-control">
            <option value="L">Laki-laki</option><option value="P">Perempuan</option>
          </select>
        </div>
        <div class="form-group"><label>Agama</label>
          <select name="agama" id="s_agama" class="form-control">
            <option>Islam</option><option>Kristen</option><option>Katolik</option><option>Hindu</option><option>Buddha</option>
          </select>
        </div>
        <div class="form-group"><label>TTL</label><input type="text" name="ttl" id="s_ttl" class="form-control" placeholder="Kota, DD MMM YYYY"/></div>
        <div class="form-group"><label>No. Kontak</label><input type="text" name="hp" id="s_hp" class="form-control" placeholder="08xx"/></div>
        <div class="form-group"><label>Golongan Darah</label>
          <select name="goldar" id="s_gol" class="form-control">
            <option>A</option><option>B</option><option>AB</option><option>O</option>
          </select>
        </div>
        <div class="form-group"><label>Kelas</label>
          <select name="id_kelas" id="s_kls" class="form-control">
            <?php mysqli_data_seek($kelasList,0); while($k=mysqli_fetch_assoc($kelasList)): ?>
            <option value="<?php echo $k['id_kelas'];?>"><?php echo htmlspecialchars($k['Kelas'].' — '.$k['Jurusan']);?></option>
            <?php endwhile;?>
          </select>
        </div>
        <div class="form-group"><label>Perusahaan PKL</label>
          <select name="id_perusahaan" id="s_prs" class="form-control">
            <?php mysqli_data_seek($prsList,0); while($p=mysqli_fetch_assoc($prsList)): ?>
            <option value="<?php echo $p['id_perusahaan'];?>"><?php echo htmlspecialchars($p['Nama_perusahaan']);?></option>
            <?php endwhile;?>
          </select>
        </div>
        <div class="form-group"><label>Pembimbing PKL</label>
          <select name="id_pembimbing" id="s_pmb" class="form-control">
            <?php mysqli_data_seek($pmbList,0); while($pb=mysqli_fetch_assoc($pmbList)): ?>
            <option value="<?php echo $pb['id_pembimbing'];?>"><?php echo htmlspecialchars($pb['nama']);?></option>
            <?php endwhile;?>
          </select>
        </div>
        <div class="form-group"><label>Wali Kelas</label>
          <select name="id_walikelas" id="s_wkl" class="form-control">
            <?php mysqli_data_seek($wklList,0); while($wk=mysqli_fetch_assoc($wklList)): ?>
            <option value="<?php echo $wk['id_walikelas'];?>"><?php echo htmlspecialchars($wk['Nama_wakel']);?></option>
            <?php endwhile;?>
          </select>
        </div>
      </div>
      <div class="form-group"><label>Alamat</label>
        <textarea name="alamat" id="s_alm" class="form-control" rows="2" placeholder="Alamat lengkap"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modalSiswa')">Batal</button>
        <button type="submit" name="simpan_siswa" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<script>
function openModal(id){document.getElementById(id).classList.add('active');}
function closeModal(id){document.getElementById(id).classList.remove('active');}
function editSiswa(d){
  document.getElementById('s_id').value=d.id_siswa;
  document.getElementById('s_nis').value=d.Nis_siswa;
  document.getElementById('s_nama').value=d.Nama_siswa;
  document.getElementById('s_jk').value=d.Jenis_kelamin;
  document.getElementById('s_agama').value=d.Agama_siswa;
  document.getElementById('s_ttl').value=d.TTL;
  document.getElementById('s_hp').value=d.NO_Kontak;
  document.getElementById('s_gol').value=d.Goldar;
  document.getElementById('s_alm').value=d.Alamat_siswa;
  document.getElementById('s_kls').value=d.id_kelas;
  document.getElementById('s_prs').value=d.id_perusahaan;
  document.getElementById('s_pmb').value=d.id_pembimbing;
  document.getElementById('s_wkl').value=d.id_walikelas;
  document.getElementById('modalSiswaTitle').innerHTML='<i class="fas fa-edit" style="margin-right:8px;"></i> Edit Siswa';
  openModal('modalSiswa');
}
</script>
<?php include '_footer_admin.php'; ?>
