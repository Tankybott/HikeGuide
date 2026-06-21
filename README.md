# HikeGuide

A hiking trail portal built as a portfolio project for a Laravel course in my studies programme. HikeGuide lets users discover hiking regions and trails, leave photo reviews, and propose new hikes, while giving administrators a full content management panel. Responsive for mobile and desktop

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
<img width="1915" height="944" alt="image" src="https://github.com/user-attachments/assets/fd2004ca-9bf2-4532-abe3-4654282f03f6" />

&nbsp;

---

### Public — Region Detail
- Full-screen photo gallery with thumbnail switcher (Alpine.js)
- Active thumbnail highlighted with green ring
- Region description
- List of all hikes belonging to the region with difficulty badges

---
<img width="1917" height="944" alt="image" src="https://github.com/user-attachments/assets/30476390-9847-4b76-bc6d-ef7d918bdc06" />

&nbsp;

---

### Public — Hikes
- Browse all trails with live search and country filter
- Propose a Hike button (authenticated users) — inline with filters on desktop, full-width above search on mobile

---
<img width="1918" height="947" alt="image" src="https://github.com/user-attachments/assets/4f6a73db-70b0-4458-a2a0-63cdb0cb57ee" />

&nbsp;

---

### Public — Hike Detail
- Photo gallery identical to region detail
- Meta bar: region link, distance, parking, gear requirements
- Reviews section with average star score

---
<img width="1916" height="942" alt="image" src="https://github.com/user-attachments/assets/286467a0-5fe9-48c6-8375-eee76d748415" />

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
<img width="1917" height="947" alt="image" src="https://github.com/user-attachments/assets/3b00ad3c-3cbd-4a09-a3e4-83b5fc8a33d0" />

&nbsp;

---

### Hike Draft Proposals
- Authenticated users can submit a hike proposal (title, description, difficulty, distance, parking/gear flags)
- Can suggest a new region name or select an existing one

---
<img width="1915" height="947" alt="image" src="https://github.com/user-attachments/assets/b44404f9-6480-4be0-878b-26ca695c2db9" />

&nbsp;

---

### Admin — Draft Review Workflow
- Admin lists all submitted proposals
- For proposals with a suggested region: create the region directly from the proposal (form pre-filled), or bind an existing region manually
- Once a region is assigned, proceed to create the hike (form pre-filled from draft)
- Draft is automatically deleted after the hike is created


&nbsp;

---

### Admin — Regions & Hikes Management
- Full CRUD for regions and hikes
- Multi-photo upload with main photo selection
- Delete individual photos on edit
- Search with live AJAX table

&nbsp;

---

### Admin — User Management
- Table of all non-admin users with search by nickname or email
- One-click permanent ban / unban with status badge


