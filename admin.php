<?php
session_start();
require_once __DIR__ . "/db_connect.php";
require_once __DIR__ . "/admin_config.php";

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if ($_POST["username"] === ADMIN_USERNAME && password_verify($_POST["password"], ADMIN_PASSWORD_HASH)) {
        $_SESSION["admin_logged_in"] = true;
    } else {
        $loginError = "Invalid username or password.";
    }
}

if (empty($_SESSION["admin_logged_in"])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8"/>
    <title>Admin Login | BoilerHours</title>
    <style>
      body { background:#181818; color:#f0f0f0; font-family:'Segoe UI',system-ui,sans-serif; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
      form { background:#222; border:1px solid #333; border-radius:12px; padding:32px; width:280px; }
      h1 { font-size:18px; margin-bottom:20px; }
      label { display:block; font-size:12px; color:#999; margin-bottom:6px; }
      input { width:100%; background:#2a2a2a; border:1px solid #333; color:#f0f0f0; padding:10px 12px; border-radius:8px; margin-bottom:14px; box-sizing:border-box; font-family:inherit; }
      button { width:100%; background:#CFB991; color:#111; border:none; padding:11px; border-radius:8px; font-weight:800; cursor:pointer; }
      .error { color:#f87171; font-size:13px; margin-bottom:14px; }
    </style>
    </head>
    <body>
      <form method="post">
        <h1>BoilerHours Admin</h1>
        <?php if (!empty($loginError)) echo '<div class="error">' . htmlspecialchars($loginError) . '</div>'; ?>
        <label>Username</label>
        <input type="text" name="username" required autofocus/>
        <label>Password</label>
        <input type="password" name="password" required/>
        <button type="submit">Log In</button>
      </form>
    </body>
    </html>
    <?php
    exit;
}

if (isset($_POST["action"], $_POST["id"])) {
    $id = (int)$_POST["id"];
    if ($_POST["action"] === "verify") {
        $stmt = $conn->prepare("UPDATE submissions SET verified = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST["action"] === "reject") {
        $stmt = $conn->prepare("DELETE FROM submissions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: admin.php" . (isset($_GET["filter"]) ? "?filter=" . urlencode($_GET["filter"]) : ""));
    exit;
}

$pendingOnly = isset($_GET["filter"]) && $_GET["filter"] === "pending";
$sql = "SELECT * FROM submissions" . ($pendingOnly ? " WHERE verified = 0" : "") . " ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>Admin | BoilerHours</title>
<style>
  :root { --gold:#CFB991; --bg:#181818; --bg2:#222; --bg3:#2a2a2a; --border:#333; --text:#f0f0f0; --sub:#999; }
  * { box-sizing:border-box; }
  body { background:var(--bg); color:var(--text); font-family:'Segoe UI',system-ui,sans-serif; margin:0; padding:24px; }
  h1 { font-size:20px; margin-bottom:4px; }
  .top { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
  .filters a { color:var(--sub); text-decoration:none; font-size:13px; margin-right:16px; padding:6px 12px; border-radius:20px; border:1px solid var(--border); }
  .filters a.active { color:var(--gold); border-color:var(--gold); }
  a.logout { color:var(--sub); font-size:12px; text-decoration:none; }
  table { width:100%; border-collapse:collapse; background:var(--bg2); border-radius:12px; overflow:hidden; }
  th, td { padding:10px 12px; text-align:left; font-size:13px; border-bottom:1px solid var(--border); vertical-align:top; }
  th { color:var(--sub); font-size:11px; text-transform:uppercase; letter-spacing:0.05em; }
  tr:last-child td { border-bottom:none; }
  .verified { color:#34d399; font-weight:700; }
  .pending { color:#fbbf24; font-weight:700; }
  .thumb { max-width:80px; max-height:80px; border-radius:6px; display:block; }
  form.inline { display:inline; }
  .btn { border:none; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer; margin-right:6px; }
  .btn-verify { background:#34d399; color:#111; }
  .btn-reject { background:#f87171; color:#111; }
</style>
</head>
<body>
  <div class="top">
    <div>
      <h1>Submissions</h1>
      <div class="filters">
        <a href="admin.php" class="<?= !$pendingOnly ? 'active' : '' ?>">All</a>
        <a href="admin.php?filter=pending" class="<?= $pendingOnly ? 'active' : '' ?>">Pending only</a>
      </div>
    </div>
    <a class="logout" href="admin.php?logout=1">Log out</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Name</th><th>Email</th><th>Professor</th><th>Course</th><th>Screenshot</th><th>Venmo/Zelle</th><th>Status</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row["full_name"]) ?></td>
        <td><?= htmlspecialchars($row["purdue_email"]) ?></td>
        <td><?= htmlspecialchars($row["professor_name"]) ?></td>
        <td><?= htmlspecialchars($row["course_name"]) ?></td>
        <td><a href="/<?= htmlspecialchars($row["screenshot_path"]) ?>" target="_blank"><img class="thumb" src="/<?= htmlspecialchars($row["screenshot_path"]) ?>" alt="screenshot" onerror="this.replaceWith('View file')"/></a></td>
        <td><?= htmlspecialchars($row["venmo_handle"] ?: "—") ?></td>
        <td class="<?= $row["verified"] ? 'verified' : 'pending' ?>"><?= $row["verified"] ? "Verified" : "Pending" ?></td>
        <td>
          <form class="inline" method="post">
            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>"/>
            <input type="hidden" name="action" value="verify"/>
            <button class="btn btn-verify" type="submit">Verify</button>
          </form>
          <form class="inline" method="post" onsubmit="return confirm('Reject and delete this submission?');">
            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>"/>
            <input type="hidden" name="action" value="reject"/>
            <button class="btn btn-reject" type="submit">Reject</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
