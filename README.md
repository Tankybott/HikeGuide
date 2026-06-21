# HikeGuide

A hiking trail portal built as a portfolio project for a Laravel course in my studies programme. HikeGuide lets users discover hiking regions and trails, leave photo reviews, and propose new hikes, while giving administrators a full content management panel.

---

## Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 |
| Templating | Blade |
| Styling | Tailwind CSS |
| Interactivity | Alpine.js |
| Database | SQLite |

---

## Features & Functionalities

### Public — Regions
- Browse all hiking regions in a responsive card grid
- Live search by name with 400 ms debounce (AJAX, no page reload)
- Filter by country — dropdown populated only from countries that have actual data

---
<!-- screenshot: regions index page -->

&nbsp;

---

### Public — Region Detail
- Full-screen photo gallery with thumbnail switcher (Alpine.js)
- Active thumbnail highlighted with green ring
- Region description
- List of all hikes belonging to the region with difficulty badges

---
<!-- screenshot: region show page -->

&nbsp;

---

### Public — Hikes
- Browse all trails with live search and country filter
- Propose a Hike button (authenticated users) — inline with filters on desktop, full-width above search on mobile

---
<!-- screenshot: hikes index page -->

&nbsp;

---

### Public — Hike Detail
- Photo gallery identical to region detail
- Meta bar: region link, distance, parking, gear requirements
- Reviews section with average star score

---
<!-- screenshot: hike show page -->

&nbsp;

---

### Reviews
- Authenticated users can leave one review per hike (1–5 stars + message)
- Up to 5 photos per review (max 10 MB each), displayed as thumbnails
- Own review pinned at top with Edit / Delete controls
- Edit mode toggled inline (Alpine.js), photo set can be fully replaced on update
- Other reviews sorted by date, show up to 5 then "Show all" toggle (no flash)
- Admins see a Delete button on every review

---
<!-- screenshot: review form and review cards -->

&nbsp;

---

### Hike Draft Proposals
- Authenticated users can submit a hike proposal (title, description, difficulty, distance, parking/gear flags)
- Can suggest a new region name or select an existing one

---
<!-- screenshot: draft proposal form -->

&nbsp;

---

### Admin — Draft Review Workflow
- Admin lists all submitted proposals
- For proposals with a suggested region: create the region directly from the proposal (form pre-filled), or bind an existing region manually
- Once a region is assigned, proceed to create the hike (form pre-filled from draft)
- Draft is automatically deleted after the hike is created

---
<!-- screenshot: admin draft show page -->

&nbsp;

---

### Admin — Regions & Hikes Management
- Full CRUD for regions and hikes
- Multi-photo upload with main photo selection
- Delete individual photos on edit
- Search with live AJAX table

---
<!-- screenshot: admin regions/hikes index and form -->

&nbsp;

---

### Admin — User Management
- Table of all non-admin users with search by nickname or email
- One-click permanent ban / unban with status badge

---
<!-- screenshot: admin users page -->

&nbsp;

