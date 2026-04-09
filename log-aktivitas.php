<?php
session_start();
include "config.php";
requireAdmin();
$active_page = 'log';
$page_title  = 'Log Aktivitas';
include '_header_admin.php';

// Ambil data log dan gabungkan dengan tabel users untuk tahu siapa yang beraksi
$query = "SELECT log_aktivitas.*, users.username 
          FROM log_aktivitas 
          LEFT JOIN users ON log_aktivitas.id_users = users.id_users 
          ORDER BY log_aktivitas.waktu DESC";
$result = mysqli_query($conn, $query);
?>

<div class="page-header">
    <h2><i class="fas fa-history"></i> Log Aktivitas Sistem</h2>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th></th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d M Y, H:i', strtotime($row['waktu'])); ?></td>
                            <td>
                                <!-- <span class="badge badge-info"> -->
                                    <!-- <i class="fas fa-user"></i> <?= htmlspecialchars($row['username'] ?? 'System/Deleted'); ?> -->
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['aktivitas']); ?></td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr>
                        <td colspan="4" style="text-align:center; padding: 20px;">Belum ada aktivitas yang tercatat.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '_footer_admin.php'; ?>