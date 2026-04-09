<?php
// ============================================================
//  sidebar.php — Komponen Sidebar Admin SIMPKL
//  Set $active_page sebelum include
// ============================================================
if (!isset($active_page)) $active_page = '';

function si($href, $icon, $label, $key, $active, $badge = 0, $danger = false) {
    $ac = ($key === $active) ? 'active' : '';
    $dg = $danger ? 'danger' : '';
    echo "<a href='{$href}' class='sidebar-item {$ac} {$dg}' data-tooltip='{$label}'>
            <i class='{$icon}'></i><span>{$label}</span>";
    if ($badge > 0) echo "<span class='badge'>{$badge}</span>";
    echo "</a>";
}
?>

<button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
  <i class="fas fa-chevron-left"></i>
</button>

<aside class="sidebar" id="sidebar">

  <div class="sidebar-section">
    <div class="sidebar-section-title">Utama</div>
    <?php si('dashboard_admin2.php',   'fas fa-th-large',           'Dashboard',       'dashboard',   $active_page); ?>
  </div>

  <div class="sidebar-divider"></div>

  <div class="sidebar-section">
    <div class="sidebar-section-title">Data Master</div>
    <?php si('admin-users.php',        'fas fa-users-cog',          'Manajemen User',  'users',       $active_page); ?>
    
    <?php si('admin-siswa.php',        'fas fa-user-graduate',      'Data Siswa',      'siswa',       $active_page); ?>
    <?php si('admin-pembimbing.php',   'fas fa-chalkboard-teacher', 'Pembimbing PKL',  'pembimbing',  $active_page); ?>
    <?php si('admin-perusahaan.php',   'fas fa-building',           'Perusahaan',      'perusahaan',  $active_page); ?>
    <?php si('admin-kelas.php',        'fas fa-school',             'Kelas',           'kelas',       $active_page); ?>
    <!-- <?php si('admin-walikelas.php',    'fas fa-user-tie',           'Wali Kelas',      'walikelas',   $active_page); ?> -->
  </div>

  <div class="sidebar-divider"></div>

  <div class="sidebar-section">
    <div class="sidebar-section-title">Aktivitas PKL</div>
    <?php si('pkl-kegiatan.php',       'fas fa-book-open',          'Kegiatan Harian', 'kegiatan',    $active_page); ?>
    <?php si('pkl-bimbingan.php',      'fas fa-comments',           'Bimbingan',       'bimbingan',   $active_page); ?>
    <?php si('pkl-kopetensi.php',      'fas fa-tasks',              'Kompetensi',      'kopetensi',   $active_page); ?>
    <?php si('pkl-laporan.php',        'fas fa-file-alt',           'Laporan PKL',     'laporan',     $active_page, 3); ?>
  </div>

  <!-- <div class="sidebar-divider"></div> -->

  <div class="sidebar-section">
    <div class="sidebar-section-title">Sistem</div>
    <!-- <?php si('notifikasi.php',         'fas fa-bell',               'Notifikasi',      'notifikasi',  $active_page, 5); ?> -->
    <!-- <?php si('pengaturan.php',         'fas fa-cog',                'Pengaturan',      'pengaturan',  $active_page); ?> -->
    <!-- <?php si('backup.php',             'fas fa-database',           'Backup Data',     'backup',      $active_page); ?> -->
    <?php si('log-aktivitas.php',      'fas fa-history',            'Log Aktivitas',   'log',         $active_page); ?>
  </div>

  <!-- <div class="sidebar-divider"></div> -->

  <div class="sidebar-section">
      <?php si('logout.php',     'fas fa-sign-out-alt','Logout',      'logout', $active_page, 0, true); ?>
  </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
