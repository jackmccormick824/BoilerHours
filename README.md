# BoilerHours

Find Purdue office hours. Actually show up.

Live at [boilerhours.com](https://boilerhours.com). Started out as a searchable directory of TA and instructor office hours. Right now it's running a submission contest to rebuild that directory for Fall 2026, so the homepage temporarily points people at the submit form instead of a course search.

## What's running right now

The contest: submit an office hour, get verified, show up on the leaderboard, win money. That means:

- A submit form (course, professor, Purdue email, full name, a required screenshot as proof, optional Venmo/Zelle for payout)
- `admin.php`, a password-protected page where I review submissions, flag duplicates, and verify or reject them
- `leaderboard.php`, ranking verified + unique submissions by submitter
- `rules.php`, the actual contest rules
- A banner on the homepage pointing at all of it

Submissions land in a MySQL `submissions` table, not flat files:

| Column | Type | Notes |
|---|---|---|
| `id` | int, PK | |
| `full_name` | varchar(100) | required |
| `purdue_email` | varchar(100) | required |
| `professor_name` | varchar(100) | required |
| `course_name` | varchar(100) | required |
| `screenshot_path` | varchar(255) | path under `uploads/screenshots/` |
| `venmo_handle` | varchar(100) | optional |
| `verified` | tinyint(1) | 0 until an admin approves it |
| `is_unique` | tinyint(1) | defaults to 1 |
| `submitted_at` | datetime | |

## Credentials

`db_connect.php` and `admin_config.php` hold real passwords and are gitignored on purpose, they only exist on the server (created by hand through Hostinger's File Manager) and never go through git. `db_connect.example.php` and `admin_config.example.php` show the shape without the actual values. If either real file is missing, `submit.php` and `admin.php` just say "server isn't configured yet" instead of blowing up.

One gotcha to watch for: `uploads/screenshots/` only has a `.gitkeep` tracked in git, the actual uploaded files aren't. If Hostinger's auto-deploy ever does a hard reset instead of a merge on push, it'll wipe those files. If screenshots start 404ing right after a deploy, that's probably why.

## Project layout

```
boilerhours/
├── index.html                # Live homepage + submit form
├── submit.php                 # Handles the form, saves the screenshot, writes to MySQL
├── admin.php                  # Review queue, login required
├── leaderboard.php
├── rules.php
├── db_connect.example.php     # Real one lives only on the server
├── admin_config.example.php   # Same deal
├── uploads/screenshots/       # Where proof screenshots land
├── fall_2026/                 # Next semester's page, same look as backup-spring-2026, courses not filled in yet
└── backup-spring-2026/        # The old live site, frozen, don't touch
```

## Running it locally

```bash
php -S localhost:8000
```

The form, admin page, and leaderboard all need a local `db_connect.php` pointed at a MySQL database with the `submissions` table above. Copy `db_connect.example.php` and fill in real values.

## Deploying

Push to `main` and Hostinger picks it up automatically:

```bash
git add .
git commit -m "your message"
git push
```

`db_connect.php` and `admin_config.php` never get touched by this since they're gitignored.

## Spring 2026 (the old site)

Before the contest, boilerhours.com was a real course search: type in CS 18200 or MA 16100, get office hours, a live "NOW" indicator for whoever's in right now, a campus map, the works. Ten courses were hardcoded straight into `index.html` — CS 18200, CS 24000, EAPS 11200, the MA sequence, and the three TDM courses.

That version is sitting untouched in `backup-spring-2026/index.html`. Don't edit it, it's just there for reference. `fall_2026/index.html` reuses its layout and logic but starts with all the course data emptied out, ready to be filled in once Fall's schedules are in.

## Contact

contact@boilerhours.com

---

Not affiliated with Purdue University.
