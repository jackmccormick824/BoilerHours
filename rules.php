<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Contest Rules | BoilerHours</title>
<link rel="icon" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+CiAgPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNiIgZmlsbD0iIzFhMWExYSIvPgogIDx0ZXh0IHg9IjE2IiB5PSIyMyIgZm9udC1mYW1pbHk9Ikdlb3JnaWEsc2VyaWYiIGZvbnQtc2l6ZT0iMjIiIGZvbnQtd2VpZ2h0PSJib2xkIiBmaWxsPSIjQ0ZCOTkxIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5CPC90ZXh0Pgo8L3N2Zz4=" type="image/svg+xml">
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

  main { max-width:640px; margin:0 auto; padding:40px 18px 60px; }
  h1 { font-size:26px; font-weight:800; margin-bottom:8px; }
  p.sub { color:var(--sub); font-size:13px; margin-bottom:32px; }
  section { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:20px 22px; margin-bottom:16px; }
  section h2 { font-size:14px; color:var(--gold); letter-spacing:0.04em; margin-bottom:8px; }
  section p, section li { font-size:14px; color:#ddd; line-height:1.6; }
  section ul { padding-left:18px; }
  .cta { display:inline-block; margin-top:8px; background:var(--gold); color:#111; font-weight:800; font-size:13px; padding:12px 24px; border-radius:10px; text-decoration:none; }
</style>
</head>
<body>

<div class="contest-banner" id="contest-banner">
  <button class="contest-banner-close" onclick="document.getElementById('contest-banner').style.display='none'" aria-label="Dismiss">&times;</button>
  <div class="contest-banner-title">Submit office hours Aug 24 to Sept 7 and win $100 or $50</div>
  <div class="contest-banner-sub">Screenshot required, verified entries only. <a href="/#submit" class="contest-banner-link">Submit yours</a></div>
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
    <a class="nav-tab" href="leaderboard.php">Leaderboard</a>
    <a class="nav-tab active" href="rules.php">Rules</a>
  </div>
</nav>

<main>
  <h1>Contest Rules</h1>
  <p class="sub">Submit office hours, get on the leaderboard, win cash.</p>

  <section>
    <h2>DATES</h2>
    <p>Submissions open Aug 24 and close Sept 7 at 11:59pm. Anything submitted after the cutoff doesn't count. Winners get announced Sept 10.</p>
  </section>

  <section>
    <h2>WHAT COUNTS</h2>
    <p>Only unique office hours count toward the leaderboard. First person to submit a given professor's office hours for a course gets the credit. If someone else already submitted it, yours won't add to your count, but you can still send it in as a correction if the listed hours are wrong.</p>
  </section>

  <section>
    <h2>SCREENSHOT REQUIRED</h2>
    <p>Every submission needs proof: a screenshot of the syllabus, course page, or an email from the professor showing the office hours. No screenshot, no credit.</p>
  </section>

  <section>
    <h2>PRIZES</h2>
    <p>1st place: $100. 2nd place: $50. Paid out via Venmo or Zelle, so make sure your handle is on your submission if you're in the running.</p>
  </section>

  <a class="cta" href="/">Submit your office hours</a>
</main>
</body>
</html>
