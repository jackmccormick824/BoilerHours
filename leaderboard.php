<?php
$dbError = null;
$rows = [];

if (!file_exists(__DIR__ . "/db_connect.php")) {
    $dbError = "Database isn't configured on this server yet.";
} else {
    require_once __DIR__ . "/db_connect.php";
    $result = $conn->query(
        "SELECT purdue_email, MAX(full_name) AS full_name, COUNT(*) AS cnt
         FROM submissions
         WHERE verified = 1 AND is_unique = 1
         GROUP BY purdue_email
         ORDER BY cnt DESC"
    );
    if ($result === false) {
        $dbError = "Couldn't load the leaderboard right now.";
    } else {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
}
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

  .contest-banner { background:var(--gold); color:#111; padding:22px 20px; text-align:center; position:relative; }
  .contest-banner-title { font-size:20px; font-weight:900; letter-spacing:-0.2px; margin-bottom:4px; }
  .contest-banner-sub { font-size:14px; font-weight:600; opacity:0.85; }
  .contest-banner-link { color:#111; text-decoration:underline; font-weight:800; }
  .contest-banner-close { position:absolute; top:12px; right:16px; background:none; border:none; color:#111; opacity:0.6; font-size:20px; line-height:1; cursor:pointer; padding:4px; font-weight:700; }
  .contest-banner-close:hover { opacity:1; }
  @media (max-width:480px) {
    .contest-banner { padding:18px 40px 18px 16px; }
    .contest-banner-title { font-size:16px; }
    .contest-banner-sub { font-size:12px; }
  }

  nav { position:sticky; top:0; z-index:1000; background:rgba(22,22,22,0.97); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; padding:0 16px; height:52px; backdrop-filter:blur(10px); gap:12px; }
  .nav-left { display:flex; align-items:center; gap:10px; flex-shrink:0; }
  .nav-logo { font-size:18px; font-weight:800; color:var(--gold); letter-spacing:-0.3px; }
  .nav-divider { width:1px; height:18px; background:var(--border); }
  .nav-sub { color:#555; font-size:12px; }
  .nav-tabs { display:flex; gap:4px; margin-left:16px; }
  .nav-tab { color:#555; font-size:12px; font-weight:600; padding:6px 12px; border-radius:20px; text-decoration:none; letter-spacing:0.04em; }
  .nav-tab:hover { color:var(--gold); }
  .nav-tab.active { color:var(--gold); background:rgba(207,185,145,0.1); }
  @media (max-width:480px) {
    .nav-divider, .nav-sub { display:none; }
    nav { padding:0 12px; }
  }

  main { max-width:600px; margin:0 auto; padding:40px 18px; }
  h1 { font-size:24px; font-weight:800; margin-bottom:6px; }
  p.sub { color:var(--sub); font-size:13px; margin-bottom:28px; }
  table { width:100%; border-collapse:collapse; background:var(--bg2); border-radius:12px; overflow:hidden; }
  th, td { padding:12px 16px; text-align:left; font-size:14px; border-bottom:1px solid var(--border); }
  th { color:var(--sub); font-size:11px; text-transform:uppercase; letter-spacing:0.05em; }
  tr:last-child td { border-bottom:none; }
  td.rank { color:var(--gold); font-weight:800; font-family:monospace; }
  .empty { text-align:center; color:#555; padding:32px 0; font-size:14px; }
  .db-error { text-align:center; color:#f87171; padding:32px 0; font-size:14px; }
</style>
</head>
<body>

<div class="contest-banner" id="contest-banner">
  <button class="contest-banner-close" onclick="document.getElementById('contest-banner').style.display='none'" aria-label="Dismiss">&times;</button>
  <div class="contest-banner-title">Submit office hours Aug 24 to Sept 7 and win $100 or $50</div>
  <div class="contest-banner-sub">Screenshot required, verified entries only. <a href="rules.php" class="contest-banner-link">See the rules</a></div>
</div>

<nav>
  <div class="nav-left">
    <a href="/" style="text-decoration:none"><span class="nav-logo">BoilerHours</span></a>
    <div class="nav-divider"></div>
    <span class="nav-sub">Purdue Office Hours</span>
  </div>
  <div class="nav-tabs">
    <a class="nav-tab" href="/">Home</a>
    <a class="nav-tab" href="/#submit">Submit Hours</a>
    <a class="nav-tab active" href="leaderboard.php">Leaderboard</a>
    <a class="nav-tab" href="rules.php">Rules</a>
  </div>
</nav>

<main>
  <h1>Leaderboard</h1>
  <p class="sub">Verified, unique office hour submissions only.</p>
  <?php if ($dbError): ?>
    <div class="db-error"><?= htmlspecialchars($dbError) ?></div>
  <?php else: ?>
  <table>
    <thead><tr><th>Rank</th><th>Name</th><th>Count</th></tr></thead>
    <tbody>
      <?php if (empty($rows)): ?>
      <tr><td colspan="3" class="empty">No verified submissions yet. Be the first.</td></tr>
      <?php else: foreach ($rows as $i => $row): ?>
      <tr>
        <td class="rank">#<?= $i + 1 ?></td>
        <td><?= htmlspecialchars($row["full_name"]) ?></td>
        <td><?= (int)$row["cnt"] ?></td>
      </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
  <?php endif; ?>
</main>
</body>
</html>
