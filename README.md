# BoilerHours

**Find Purdue office hours. Actually show up.**

Live at [boilerhours.com](https://boilerhours.com). Started as a searchable directory of TA and instructor office hours for Purdue courses, currently running a submission contest to rebuild that directory for Fall 2026.

---

## Current: Fall 2026 Submission Contest

The homepage no longer has the old course search (see [Spring 2026](#spring-2026-office-hours-archived) below for why). Right now the site is focused on collecting fresh office hours submissions through a contest:

- **Contest banner** on every page, dismissible, links to the rules
- **Submit form** — full name, Purdue email, professor name, course, a required screenshot (image or PDF, up to 5MB) as proof, and an optional Venmo/Zelle handle for prize payout
- **`admin.php`** — password-protected review queue. Lists submissions newest first, lets you Verify or Reject (Reject deletes the row) each one, with a pending-only filter
- **`leaderboard.php`** — verified + unique submissions grouped by submitter email, ranked by count
- **`rules.php`** — contest dates, uniqueness rule, screenshot requirement, prizes, payout method, winner announcement date

### Database

Submissions are stored in MySQL, not flat files. The `submissions` table:

| Column | Type | Notes |
|---|---|---|
| `id` | int, PK | |
| `full_name` | varchar(100) | required |
| `purdue_email` | varchar(100) | required |
| `professor_name` | varchar(100) | required |
| `course_name` | varchar(100) | required |
| `screenshot_path` | varchar(255) | required, relative path under `uploads/screenshots/` |
| `venmo_handle` | varchar(100) | optional |
| `verified` | tinyint(1) | default 0, admin sets to 1 |
| `is_unique` | tinyint(1) | default 1 |
| `submitted_at` | datetime | default current timestamp |

### Server-only config files (never committed)

Two files hold real credentials and are gitignored on purpose. They have to be created directly on Hostinger (File Manager or SFTP), not pushed through git:

- **`db_connect.php`** — MySQL host/dbname/username/password. Template in `db_connect.example.php`.
- **`admin_config.php`** — admin login username + a `password_hash()`'d password for `admin.php`. Template in `admin_config.example.php`.

If either is missing on the server, `submit.php` and `admin.php` show a plain "server isn't configured yet" message instead of crashing.

**Known gotcha:** `uploads/screenshots/` holds user-uploaded files and is only tracked via a `.gitkeep`. If Hostinger's auto-deploy ever does a hard reset/re-checkout instead of a plain merge on push, it can wipe uploaded files that aren't in git. Worth confirming with Hostinger's deploy behavior if screenshots start 404ing after a push.

## Tech Stack

- Vanilla HTML/CSS/JS on the frontend, no frameworks, no build step
- PHP + MySQL (mysqli) for submissions, admin, and the leaderboard
- Hosted on Hostinger with GitHub auto-deploy

## Project Structure

```
boilerhours/
├── index.html                   # Homepage + submit form (single-file SPA-style)
├── submit.php                   # Form handler — validates, saves screenshot, inserts into DB
├── admin.php                    # Password-protected submission review queue
├── leaderboard.php              # Verified + unique submission counts, ranked
├── rules.php                    # Contest rules page
├── db_connect.example.php       # Placeholder DB credentials template
├── admin_config.example.php     # Placeholder admin login template
├── uploads/screenshots/         # Uploaded proof screenshots (gitignored contents)
├── backup-spring-2026/          # Archived Spring 2026 static site, read-only
└── README.md
```

`db_connect.php` and `admin_config.php` exist locally/on-server but are gitignored, they won't show up in a fresh clone.

## Local Development

```bash
php -S localhost:8000
```

Then go to `http://localhost:8000`. You'll need a local `db_connect.php` (copy `db_connect.example.php` and point it at a local MySQL instance with the `submissions` table) for the form, admin page, and leaderboard to work.

## Deployment

Connected to Hostinger via GitHub auto-deploy. Push to `main` and boilerhours.com updates within seconds.

```bash
git add .
git commit -m "your message"
git push
```

`db_connect.php` and `admin_config.php` are never part of that push, they live only on the server.

## Spring 2026 Office Hours (archived)

Before the contest, the homepage was a hardcoded search tool covering these courses for Spring 2026:

| Course | Title |
|---|---|
| CS 18200 | Foundations of Computer Science |
| CS 24000 | Programming in C |
| EAPS 11200 | The Earth Through Time |
| MA 15300 | Mathematics For Elementary Education I |
| MA 16100 | Plane Analytic Geometry And Calculus I |
| MA 16200 | Plane Analytic Geometry And Calculus II |
| MA 26100 | Multivariate Calculus |
| TDM 10200 | Introduction to Data Science |
| TDM 20200 | Data Science in the Data Mine |
| TDM 30200 | Advanced Data Science in the Data Mine |

That version had course-code search, a live "NOW" indicator for whichever slot was active, day tabs, an interactive campus map per course, in-person/Zoom tags for TDM courses, and a lab section browser for CS 24000. All of that data was hardcoded directly in `index.html`.

It's preserved, untouched, in **`backup-spring-2026/index.html`** for reference. Treat it as read-only, it's not linked from the live site and isn't part of the current build.

## Contact

Questions or want to submit office hours? Email [contact@boilerhours.com](mailto:contact@boilerhours.com)

---

*Not affiliated with Purdue University.*
