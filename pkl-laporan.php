<?php
session_start();
include "config.php";
requireAdmin();
$active_page = 'laporan';
$page_title  = 'Laporan PKL';
include '_header_admin.php';
?>
<div class="page-header">
  <h2><i class="fas fa-file-alt"></i> Laporan PKL</h2>
</div>
<div class="card" style="text-align:center;padding:60px 20px;">
  <i class="fas fa-file-alt" style="font-size:2.5rem;color:#334155;display:block;margin-bottom:14px;"></i>
  <h3 style="color:#475569;margin-bottom:8px;">Laporan PKL</h3>
  <p style="color:#334155;">Halaman ini sedang dalam pengembangan.</p>
</div>
<?php include '_footer_admin.php'; ?>
