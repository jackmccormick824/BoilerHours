# BoilerHours

**Find Purdue office hours. Actually show up.**

Live at [boilerhours.com](https://boilerhours.com) — a fast, searchable directory of TA and instructor office hours for Purdue University courses. Built after getting tired of hunting through syllabi and course pages every time I needed help.

---

## Features

- Search by course code (CS 18200, MA 16100, TDM 10200, etc.)
- Live "NOW" indicator — highlights whichever TA slot is currently active
- Day tabs with today auto-selected
- Interactive campus map showing the exact building for each course
- In-person vs. Zoom tags for TDM courses
- Lab section browser for CS 24000
- Submit Hours form — sends directly to contact@boilerhours.com with photo attachment via PHP mail

## Courses Currently Supported

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

## Tech Stack

- Vanilla HTML/CSS/JS — no frameworks, no build step
- Leaflet.js + OpenStreetMap for campus maps
- PHP (`submit.php`) for the contact form with file upload
- Hosted on Hostinger with GitHub auto-deploy

## Project Structure

```
boilerhours/
├── index.html      # Main app — all course data, UI, and logic
├── submit.php      # Form handler — receives POST, emails submission with photo
└── README.md
```

## Local Development

No build step needed. Just open `index.html` in a browser. To test the submit form locally you'll need a local PHP server:

```bash
php -S localhost:8000
```

Then go to `http://localhost:8000`.

## Deployment

Connected to Hostinger via GitHub auto-deploy. Push to `main` and boilerhours.com updates within seconds.

```bash
git add .
git commit -m "your message"
git push
```

## Adding a New Course

All course data lives in `index.html`. To add a course:

1. Add the building GPS coords to `BUILDINGS_GPS` if it's a new location
2. Add the schedule data as a new const (follow the pattern of `CS_HOURS`, `EAPS_HOURS`, etc.)
3. Register the course in the `COURSES` object at the bottom of the data section
4. It'll automatically appear in search and the course pills

## Contact

Questions or want to submit office hours? Email [contact@boilerhours.com](mailto:contact@boilerhours.com)

---

*Not affiliated with Purdue University.*
