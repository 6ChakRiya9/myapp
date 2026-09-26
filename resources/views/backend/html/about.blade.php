{{--
| NOTE: about.blade.php — About — អំពី ShelfControl
|
| ភ្ជាប់ពី file៖
|   - routes/web.php                              → URL /about
|   - app/Http/Controllers/indexcontroller.php    → method about()
|   - app/Http/Middleware/TrackVisit.php          → រាល់ការបើក page នេះត្រូវបានកត់ត្រា
|
| ភ្ជាប់ទៅ file៖
|   - resources/views/backend/partials/analytics.blade.php → @include នៅក្នុង <head>
|   - public/img/...                              → រូបភាព (តាម asset('img/...'))
| Menu link ទៅ៖ / (index), /second (library), /third (bookdetails), /about (about)
--}}
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShelfControl — Rebuild Your Mindset</title>
  
  <style>
    :root {
  --c1-darkest: #06141b; /* Titles, Headings & Primary Text */
  --c2-navy: #11212d; /* Header & Footer Section Background */
  --c3-slate: #253745; /* Dark Accent / Button Background */
  --c4-steel: #4a5c6a; /* Borders & Subtle Accents */
  --c5-silver: #9ba8ab; /* Card Cover Placeholder & Badges */
  --c6-light: #c3cfdc; /* Main Body Page Background (Light) */
}

/* RESET DEFAULT STYLES */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background-color: var(--c6-light);
  color: var(--c1-darkest);
  font-family:
    system-ui,
    -apple-system,
    BlinkMacSystemFont,
    "Segoe UI",
    Roboto,
    sans-serif;
  line-height: 1.6;
}

.container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

/* =========================================================
   HEADER & NAVIGATION
   ========================================================= */
.site-header {
  background-color: var(--c2-navy);
  border-bottom: 3px solid var(--c4-steel);
  position: sticky;
  top: 0;
  z-index: 1000;
}

/* STACKED CENTERED HEADER (MOBILE / COMPACT VIEW) */
.header-container {
  display: flex;
  flex-direction: column; /* Stacks logo on top, nav on bottom */
  align-items: center;
  justify-content: center;
  gap: 0.75rem; /* Space between logo and navigation links */
  padding: 1rem 1.5rem;
}

.main-nav a {
  white-space: nowrap;
  font-size: 0.9rem;
}

/* LOGO */
.logo {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  text-decoration: none;
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--c6-light);
}

.logo-icon img {
  width: 32px;
  height: 32px;
  object-fit: contain;
  display: block;
}

.logo .highlight {
  color: var(--c5-silver);
}

/* NAVIGATION LINKS */
.main-nav ul {
  display: flex;
  list-style: none;
  gap: 2rem;
  margin: 0;
  padding: 0;
}

.main-nav a {
  position: relative;
  text-decoration: none;
  color: var(--c5-silver);
  font-weight: 500;
  padding-bottom: 6px;
  white-space: nowrap; /* Prevents long labels like "Book Details" from wrapping */
  transition: color 0.3s ease;
}

/* Base Underline Setup */
.main-nav a::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0%;
  height: 2px;
  background-color: var(--c6-light);
  transition: width 0.3s ease;
}

.main-nav a:hover::after {
  width: 100%;
}

.main-nav a:hover {
  color: var(--c6-light);
}

/* BUTTONS */
.btn-primary {
  background-color: var(--c3-slate);
  color: var(--c6-light);
  padding: 0.6rem 1.2rem;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 700;
  transition: background-color 0.2s ease;
}
.btn-primary:hover {
  background-color: var(--c1-darkest);
}
/* Container for the pill badges */
.stats-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1.5rem;
  margin: 2rem 0;
  flex-wrap: wrap;
}

/* Outer Pill Shape */
.stat-pill {
  background-color: var(--c2-navy); /* #11212D */
  padding: 0.75rem 2rem 0.75rem 0.85rem;
  border-radius: 50px; /* Fully rounded pill shape */
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Circular Icon Background */
.stat-icon {
  width: 52px;
  height: 30px;
  background-color: rgba(255, 255, 255, 0.08); /* Dark subtle circle layer */
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #38bdf8; /* Vibrant accent blue for icons */
  font-size: 1.2rem;
  flex-shrink: 0;
}

/* Text Content */
.stat-details {
  display: flex;
  flex-direction: column;
}

.stat-number {
  color: #ffffff;
  font-size: 1rem;
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: 0.5px;
}

.stat-label {
  color: var(--c5-silver); /* #9BA8AB */
  font-size: 0.68rem;
  font-weight: 700;
  letter-spacing: 1px;
  margin-top: 0.2rem;
}
/* =========================================================
   ABOUT SECTION
   ========================================================= */
.about-section {
  padding: 4rem 0;
  background-color: var(--c6-light); /* Dark Navy contrasting block at bottom */
  color: var(--c6-light);
  border-top: 1px solid var(--c4-steel);
}

.about-container {
  max-width: 750px;
  text-align: center;
}

.about-container h2 {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: var(--c2-navy);
}

.about-text {
  color: var(--c2-navy);
  font-size: 1.05rem;
}

/* RESPONSIVE DESIGN */
@media (max-width: 600px) {
  .header-container {
    flex-direction: column;
    gap: 1rem;
  }
  .hero-content h1 {
    font-size: 2rem;
  }
}
/* =========================================================
   RESPONSIVE MOBILE ADJUSTMENTS
   ========================================================= */
@media (max-width: 600px) {
  /* Forces exactly 2 equal columns on mobile screens */
  .book-row {
    grid-template-columns: repeat(2, 1fr);
    gap: 0.85rem; /* Tighter gap for small screens */
  }

  .card-info {
    padding: 0.5rem; /* Reduces inner padding so text fits nicely */
  }

  .card-info h3 {
    font-size: 0.78rem; /* Slightly smaller title on mobile */
  }

  .card-info .author {
    font-size: 0.65rem;
  }
}

  </style>
      @include('backend.partials.analytics')
  </head>
  <body>
    <!-- HEADER & NAVIGATION -->
    <header class="site-header">
      <div class="header-container">
        <a href="#" class="logo">
          <span class="logo-icon">
            <img src="{{ asset('img/pfp.png') }}" alt="ShelfControl Logo" />
          </span>
          <span class="logo-text"
            >Shelf<span class="highlight">Control</span></span
          >
        </a>

        <nav class="main-nav">
          <ul>
            <li><a href="/" class="active">Home</a></li>
            <li><a href="/second">Library</a></li>
            <li>
              <a href="/third">Book Details</a>
            </li>
            <li><a href="/about">About</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <!-- ABOUT SECTION -->
    <section id="about" class="about-section">
      <div class="container about-container">
        <h2>About ShelfControl</h2>
        <p class="about-text">
          Life gets heavy, and standard advice often falls flat. ShelfControl
          was created with a single purpose: to curate books that actually help
          you regain clarity, reshape your inner self, and bring motivation back
          into your life. We do not focus on fluff—only books that deliver real
          mental tools for self-improvement.
        </p>
      </div>
    </section>
  </body>
</html>
