<?php
session_start();
include "config.php";
requireAdmin();

// ---- Statistik dari tabel simpkl_2 ----
$total_siswa      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM siswa"))['c'];
$total_pembimbing = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM pembimbing_pkl"))['c'];
$total_perusahaan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM perusahaan"))['c'];
$total_kelas      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM kelas"))['c'];
$total_kegiatan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM kegiatan"))['c'];
$total_bimbingan  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM bimbingan"))['c'];
$total_users      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM users"))['c'];




$active_page = 'dashboard';
$page_title  = 'Dashboard Admin';
include '_header_admin.php';
?>

<!-- Welcome -->
<div class="welcome-section delay-1">
  <div>
    <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['user']['username']); ?> 👋</h1>
    <p>Pusat pengelolaan data Sistem Informasi PKL.</p>
  </div>
  <div class="status-badge">
    <div class="status-dot"></div>
    Online
  </div>
</div>

<!-- Stat Cards -->
<div class="section-title">Ringkasan Data</div>
<div class="stat-grid">

  <div class="stat-card delay-1">
    <div class="card-icon">
      <i class="fas fa-user-graduate" style="color:#f1f5f9;"></i>
    </div>
    <h3>Total Siswa</h3>
    <div class="number"><?php echo $total_siswa; ?></div>
    <div class="trend">Siswa terdaftar PKL</div>
  </div>

  <div class="stat-card delay-2">
    <div class="card-icon">
      <i class="fas fa-chalkboard-teacher" style="color:#f59e0b;"></i>
    </div>
    <h3>Pembimbing PKL</h3>
    <div class="number" style="color:#f59e0b;"><?php echo $total_pembimbing; ?></div>
    <div class="trend">Pembimbing di perusahaan</div>
  </div>

  <div class="stat-card delay-3">
    <div class="card-icon">
      <i class="fas fa-building" style="color:#ef4444;"></i>
    </div>
    <h3>Perusahaan Mitra</h3>
    <div class="number" style="color:#ef4444;"><?php echo $total_perusahaan; ?></div>
    <div class="trend">Perusahaan mitra PKL</div>
  </div>

  <div class="stat-card delay-4">
    <div class="card-icon">
      <i class="fas fa-school" style="color:#93c5fd;"></i>
    </div>
    <h3>Kelas</h3>
    <div class="number" style="color:#93c5fd;"><?php echo $total_kelas; ?></div>
    <div class="trend">Kelas aktif</div>
  </div>

  <div class="stat-card delay-5">
    <div class="card-icon">
      <i class="fas fa-book-open" style="color:#c4b5fd;"></i>
    </div>
    <h3>Kegiatan Harian</h3>
    <div class="number" style="color:#c4b5fd;"><?php echo $total_kegiatan; ?></div>
    <div class="trend">Total entri jurnal</div>
  </div>

  <!-- <div class="stat-card">
    <div class="card-icon">
      <i class="fas fa-comments" style="color:#4ade80;"></i>
    </div>
    <h3>Bimbingan</h3>
    <div class="number" style="color:#4ade80;"><?php echo $total_bimbingan; ?></div>
    <div class="trend">Sesi bimbingan tercatat</div>
  </div> -->

</div>

<!-- Quick Actions -->
<div class="section-title delay-2">Aksi Cepat</div>
<div class="quick-grid">
  <a href="admin-siswa.php"      class="quick-card delay-1"><i class="fas fa-user-plus"></i> Tambah Siswa</a>
  <a href="admin-perusahaan.php" class="quick-card delay-2"><i class="fas fa-city"></i> Tambah Perusahaan</a>
  <a href="admin-pembimbing.php" class="quick-card delay-3"><i class="fas fa-user-tie"></i> Tambah Pembimbing</a>
  <a href="admin-kelas.php"      class="quick-card delay-4"><i class="fas fa-school"></i> Kelola Kelas</a>
  <a href="pkl-kegiatan.php"     class="quick-card delay-5"><i class="fas fa-book-open"></i> Lihat Kegiatan</a>
  <a href="backup.php"           class="quick-card"><i class="fas fa-database"></i> Backup Data</a>
</div>

<!-- 2 Panel -->
<div class="two-col">

  <!-- Siswa Terbaru -->
   <div class="activity-card">
    <h3><i class="fas fa-users"></i> Manajemen User</h3>
    <!-- <div class="activity-list">
    <?php
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE is_deleted = 0 ORDER BY id_users DESC");
    // Ambil data yang is_deleted nya 0

while($data = mysqli_fetch_array($sql)){
?>
    <div class="activity-item">
        <p><?= $data['username']; ?></p>
        <a href="user_aksi.php?hapus=<?= $data['id_users']; ?>" onclick="return confirm('Yakin?')">Hapus</a>
    </div>  
<?php } ?> -->
    </div>
</div>

    <?php
    $res = mysqli_query($conn, "SELECT s.Nama_siswa, k.Kelas, p.Nama_perusahaan
      FROM siswa s
      LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
      LEFT JOIN perusahaan p ON s.id_perusahaan = p.id_perusahaan
      ORDER BY s.id_siswa DESC LIMIT 4");
    while ($r = mysqli_fetch_assoc($res)):
    ?>
    <div class="activity-item">
      <div class="activity-icon">
        <i class="fas fa-user-graduate" style="color:#94a3b8;"></i>
      </div>
      <div class="activity-text">
        <p><strong><?php echo htmlspecialchars($r['Nama_siswa']); ?></strong></p>
        <span><?php echo htmlspecialchars($r['Kelas'] ?? '-'); ?> &mdash; <?php echo htmlspecialchars($r['Nama_perusahaan'] ?? '-'); ?></span>
      </div>
    </div>
    <?php endwhile; ?>
  </div> -->

  <!-- Bimbingan Terbaru -->
  <!-- <div class="panel delay-4">
    <div class="panel-header">
      <h3><i class="fas fa-comments" style="color:#94a3b8;"></i> Bimbingan Terbaru</h3>
      <a href="pkl-bimbingan.php">Lihat semua</a>
    </div>
    <?php
    $res2 = mysqli_query($conn, "SELECT b.materi_pembimbing, b.hari_tanggal_bimbingan, pb.nama
      FROM bimbingan b
      LEFT JOIN pembimbing_pkl pb ON b.id_pembimbing = pb.id_pembimbing
      ORDER BY b.id_bimbingan DESC LIMIT 4");
    if (mysqli_num_rows($res2) === 0):
    ?>
      <p style="text-align:center;padding:20px 0;color:#334155;font-size:.82rem;">
        Belum ada data bimbingan.
      </p>
    <?php
    else:
    while ($r2 = mysqli_fetch_assoc($res2)):
    ?>
    <div class="activity-item">
      <div class="activity-icon">
        <i class="fas fa-comments" style="color:#94a3b8;"></i>
      </div>
      <div class="activity-text">
        <p><?php echo htmlspecialchars($r2['materi_pembimbing']); ?></p>
        <span><?php echo htmlspecialchars($r2['nama'] ?? '-'); ?> &mdash; <?php echo $r2['hari_tanggal_bimbingan'] ?? '-'; ?></span>
      </div>
    </div>
    <?php endwhile; endif; ?>
  </div> -->

</div>

<!-- Status Sistem -->
<div class="panel delay-5" style="margin-bottom:0;">
  <div class="panel-header">
    <h3><i class="fas fa-server" style="color:#94a3b8;"></i> Status Sistem</h3>
    <span style="font-size:.75rem;color:#4ade80;">● Semua normal</span>
  </div>
  <div class="status-list">
    <div class="status-row">
      <span>Database</span>
      <div class="progress-bar"><div class="progress-fill" style="width:38%;background:#f1f5f9;"></div></div>
      <div class="val">38% digunakan</div>
    </div>
    <div class="status-row">
      <span>Penyimpanan</span>
      <div class="progress-bar"><div class="progress-fill" style="width:54%;background:#f59e0b;"></div></div>
      <div class="val">54% digunakan</div>
    </div>
    <div class="status-row">
      <span>Memori</span>
      <div class="progress-bar"><div class="progress-fill" style="width:25%;background:#4ade80;"></div></div>
      <div class="val">25% digunakan</div>
    </div>
    <div class="status-row">
      <span>Uptime</span>
      <div class="progress-bar"><div class="progress-fill" style="width:99%;background:#93c5fd;"></div></div>
      <div class="val">99.9%</div>
    </div>
  </div>
</div>

<?php include '_footer_admin.php'; ?>
