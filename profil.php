<?php
session_start();
include "config.php";
requireAdmin();
$active_page = 'profil';
$page_title  = 'Profil Saya';
include '_header_admin.php';
?>
<div class="page-header">
  <h2><i class="fas fa-user-circle"></i> Profil Saya</h2>
</div>
<div class="card" style="text-align:center;padding:60px 20px;">
  <i class="fas fa-user-circle" style="font-size:2.5rem;color:#334155;display:block;margin-bottom:14px;"></i>
  <h3 style="color:#475569;margin-bottom:8px;">Profil Saya</h3>
  <p style="color:#334155;">Halaman ini sedang dalam pengembangan.</p>
</div>
<?php include '_footer_admin.php'; ?>
