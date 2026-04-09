<?php
session_start();
include "config.php";
requireAdmin();
$active_page = 'users';
$page_title  = 'Manajemen User';

// Ambil data filter & search
$search = clean($_GET['s'] ?? '');
$filter = clean($_GET['role'] ?? '');

// Filter UTAMA: Hanya ambil yang is_deleted-nya 0
$where  = "WHERE is_deleted = 0"; 
if ($search) $where .= " AND username LIKE '%$search%'";
if ($filter) $where .= " AND role='$filter'";

$rows = mysqli_query($conn, "SELECT * FROM users $where ORDER BY id_users DESC");
include '_header_admin.php';
?>

<div class="page-header">
  <h2><i class="fas fa-users-cog"></i> Manajemen User</h2>
  <button class="btn btn-primary btn-sm" onclick="openModal()">
    <i class="fas fa-user-plus"></i> Tambah User
  </button>
</div>

<div class="card" style="margin-bottom:16px;">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
    <div class="search-bar"><i class="fas fa-search"></i>
      <input type="text" name="s" placeholder="Cari username..." value="<?php echo htmlspecialchars($search);?>"/>
    </div>
    <select name="role" class="form-control" style="width:auto;padding:9px 14px;">
      <option value="">Semua Role</option>
      <option value="admin"      <?php if($filter==='admin')      echo 'selected';?>>Admin</option>
      <option value="siswa"      <?php if($filter==='siswa')      echo 'selected';?>>Siswa</option>
      <option value="pembimbing" <?php if($filter==='pembimbing') echo 'selected';?>>Pembimbing</option>
      <option value="wakasek"    <?php if($filter==='wakasek')    echo 'selected';?>>Wakasek</option>
    </select>
    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-filter"></i> Filter</button>
    <a href="admin-users.php" class="btn btn-sm" style="background:rgba(255,255,255,.06);color:#64748b;">Reset</a>
  </form>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead>
        <tr><th>#</th><th>Username</th><th>Role</th><th>Aksi</th></tr>
      </thead>
      <tbody>
      <?php $no=1; while($r=mysqli_fetch_assoc($rows)): ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><i class="fas fa-user" style="color:#94a3b8;margin-right:8px;"></i>
          <?php echo htmlspecialchars($r['username']);?></td>
        <td><?php
          $map = ['admin'=>'pill-white','siswa'=>'pill-blue','pembimbing'=>'pill-yellow','wakasek'=>'pill-purple'];
          $cls = $map[$r['role']] ?? 'pill-white';
          echo "<span class='pill {$cls}'>".ucfirst($r['role'])."</span>";
        ?></td>
        <td style="display:flex;gap:6px;">
          <button class="btn btn-warning btn-sm"
            onclick="editUser(<?php echo $r['id_users'].',\''.htmlspecialchars($r['username']).'\',\''.$r['role'].'\'';?>)">
            <i class="fas fa-edit"></i> Edit
          </button>
          <?php if ($r['id_users'] != $_SESSION['user']['id_user']): ?>
          <a href="user_aksi.php?hapus=<?php echo $r['id_users'];?>" class="btn btn-danger btn-sm"
             onclick="return confirm('Yakin hapus user ini dari tampilan?')">
            <i class="fas fa-trash"></i>
          </a>
          <?php endif;?>
        </td>
      </tr>
      <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal-overlay" id="modalUser">
  <div class="modal">
    <div class="modal-header">
      <h3 id="modalTitle">Tambah User</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <form action="user_aksi.php" method="POST">
      <input type="hidden" name="id" id="u_id" value="0"/>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" id="u_username" class="form-control" required/>
      </div>
      <div class="form-group">
        <label>Role</label>
        <select name="role" id="u_role" class="form-control">
          <option value="siswa">Siswa</option>
          <option value="pembimbing">Pembimbing</option>
          <option value="wakasek">Wakasek</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="form-group">
        <label>Password (Kosongkan jika tidak ganti)</label>
        <input type="password" name="password" class="form-control"/>
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(){document.getElementById('modalUser').classList.add('active');}
function closeModal(){document.getElementById('modalUser').classList.remove('active');}
function editUser(id,uname,role){
  document.getElementById('u_id').value=id;
  document.getElementById('u_username').value=uname;
  document.getElementById('u_role').value=role;
  openModal();
}
</script>
<?php include '_footer_admin.php'; ?>