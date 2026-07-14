<?php
require_once __DIR__ . "/db_connect.php";

$result = $conn->query(
    "SELECT purdue_email, MAX(full_name) AS full_name, COUNT(*) AS cnt
     FROM submissions
     WHERE verified = 1 AND is_unique = 1
     GROUP BY purdue_email
     ORDER BY cnt DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Leaderboard | BoilerHours</title>
<style>
  :root { --gold:#CFB991; --bg:#181818; --bg2:#222; --border:#333; --text:#f0f0f0; --sub:#999; }
  * { box-sizing:border-box; margin:0; padding:0; }
  body { background:var(--bg); color:var(--text); font-family:'Segoe UI',system-ui,sans-serif; min-height:100vh; }
  nav { border-bottom:1px solid var(--border); padding:14px 20px; display:flex; align-items:center; gap:16px; }
  nav a { color:#555; text-decoration:none; font-size:13px; }
  nav a.logo { color:var(--gold); font-weight:800; font-size:16px; }
  main { max-width:600px; margin:0 auto; padding:40px 18px; }
  h1 { font-size:24px; font-weight:800; margin-bottom:6px; }
  p.sub { color:var(--sub); font-size:13px; margin-bottom:28px; }
  table { width:100%; border-collapse:collapse; background:var(--bg2); border-radius:12px; overflow:hidden; }
  th, td { padding:12px 16px; text-align:left; font-size:14px; border-bottom:1px solid var(--border); }
  th { color:var(--sub); font-size:11px; text-transform:uppercase; letter-spacing:0.05em; }
  tr:last-child td { border-bottom:none; }
  td.rank { color:var(--gold); font-weight:800; font-family:monospace; }
  .empty { text-align:center; color:#555; padding:32px 0; font-size:14px; }
</style>
</head>
<body>
<nav>
  <a class="logo" href="/">BoilerHours</a>
  <a href="/">Home</a>
  <a href="rules.php">Rules</a>
</nav>
<main>
  <h1>Leaderboard</h1>
  <p class="sub">Verified, unique office hour submissions only.</p>
  <table>
    <thead><tr><th>Rank</th><th>Name</th><th>Count</th></tr></thead>
    <tbody>
      <?php $rank = 0; while ($row = $result->fetch_assoc()): $rank++; ?>
      <tr>
        <td class="rank">#<?= $rank ?></td>
        <td><?= htmlspecialchars($row["full_name"]) ?></td>
        <td><?= (int)$row["cnt"] ?></td>
      </tr>
      <?php endwhile; ?>
      <?php if ($rank === 0): ?>
      <tr><td colspan="3" class="empty">No verified submissions yet. Be the first.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
</body>
</html>
