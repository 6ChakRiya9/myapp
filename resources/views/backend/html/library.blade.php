{{--
| NOTE: library.blade.php — Library — បញ្ជីសៀវភៅ ១៨ ក្បាល
|
| ភ្ជាប់ពី file៖
|   - routes/web.php                              → URL /second
|   - app/Http/Controllers/indexcontroller.php    → method library()
|   - app/Http/Middleware/TrackVisit.php          → រាល់ការបើក page នេះត្រូវបានកត់ត្រា
|
| ភ្ជាប់ទៅ file៖
|   - resources/views/backend/partials/analytics.blade.php → @include នៅក្នុង <head>
|   - public/img/...                              → រូបភាព (តាម asset('img/...'))
|   - /book/{file} (routes/web.php)              → ចុចសៀវភៅ → កត់ត្រា view → ប្តូរទិសទៅ public/pdf/{file}
|
| ចំនួន 👁៖ $bookViews មកពី library() → Visit (path /book/{file})
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
   LIBRARY SECTION (Multi-Row Grid Layout)
   ========================================================= */
.library-section {
  padding: 1rem 0;
  border-top: 1px solid var(--c5-silver);
}
/* 1. MAKE CONTAINER FULL-WIDTH */
.container {
  max-width: 100%; /* Allows content to stretch across the full screen */
  padding: 2rem 2rem; /* Keeps a small 2rem padding so cards don't hit screen edges */
}

.section-title {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 0.5rem;
  color: var(--c1-darkest);
}

.section-subtitle {
  text-align: center;
  color: var(--c4-steel);
  margin-bottom: 5rem;
}

/* Multi-Row Grid (Replaces scrolling flex layout) */
.book-row {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 3rem;
  width: 100%;
}

/* Individual Card Sizing */
.mini-book-card {
  width: 100%;
  /* background-color: #ffffff; */
  background-color: var(--c2-navy);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease;
}

.mini-book-card:hover {
  transform: translateY(-4px);
}

/* Book Cover Ratio */
.card-cover {
  width: 100%;
  height: 260px;
  overflow: hidden;
  background-color: var(--c5-silver);
}

.card-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* Card Text & Information */
.card-info {
  padding: 0.75rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex-grow: 1;
}

.card-info h3 {
  font-size: 0.82rem;
  font-weight: 700;
  color: #dbdae0;
  margin-bottom: 0.25rem;
  line-height: 1.25;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.card-info .author {
  font-size: 0.7rem;
  color: #bbb7b7;
  margin-bottom: 0.5rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Footer Views */
.card-footer {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  font-size: 0.7rem;
  color: #bbb7b7;
  border-top: 1px solid #eeeeee;
  padding-top: 0.4rem;
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

    <!-- LIBRARY SECTION -->
    <section id="library" class="library-section">
      <div class="container">
        <h2 class="section-title">The Mindset Library</h2>
        <p class="section-subtitle">
          Books to transform your habits, focus, and life.
        </p>

        <div class="book-row">
          <!-- Card 1 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/the-let-them-theory-1768546359.pdf') }}">
                <img src="{{ asset('img/letthem.png') }}" alt="The Let Them Theory" />
              </a>
            </div>
            <div class="card-info">
              <h3>The Let Them Theory</h3>
              <p class="author">By: Mel Robbins</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-let-them-theory-1768546359.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>

          <!-- Card 2 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/the-48-laws-of-power-1767277708.pdf') }}">
                <img src="{{ asset('img/law.png') }}" alt="The 48 Laws of Power" />
              </a>
            </div>
            <div class="card-info">
              <h3>The 48 Laws of Power</h3>
              <p class="author">By: Robert Greene</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-48-laws-of-power-1767277708.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>

          <!-- Card 3 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/atomic-habits-an-easy-and-proven-way-to-build-good-habits-and-break-bad-ones-1767277354.pdf') }}"
              >
                <img src="{{ asset('img/atomichabits.png') }}" alt="Atomic Habits" />
              </a>
            </div>
            <div class="card-info">
              <h3>Atomic Habits</h3>
              <p class="author">By: James Clear</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['atomic-habits-an-easy-and-proven-way-to-build-good-habits-and-break-bad-ones-1767277354.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>

          <!-- Card 4 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/who-moved-my-cheese-1767102933.pdf') }}">
                <img src="{{ asset('img/my cheese.png') }}" alt="Who Moved My Cheese?" />
              </a>
            </div>
            <div class="card-info">
              <h3>Who Moved My Cheese?</h3>
              <p class="author">By: Spencer Johnson</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['who-moved-my-cheese-1767102933.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 5 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/cant-hurt-me-master-your-mind-and-defy-the-odds-1774330025.pdf') }}"
              >
                <img
                  src="{{ asset('img/canthurtme.png') }}"
                  alt="Can’t Hurt Me: Master Your Mind and Defy the"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>Can’t Hurt Me: Master Your Mind and Defy the</h3>
              <p class="author">By: David Goggins</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['cant-hurt-me-master-your-mind-and-defy-the-odds-1774330025.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 6 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/ego-is-the-enemy-1767251112.pdf') }}">
                <img src="{{ asset('img/ego.png') }}" alt="Ego Is the Enemy" />
              </a>
            </div>
            <div class="card-info">
              <h3>Ego Is the Enemy</h3>
              <p class="author">By: Ryan Holiday</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['ego-is-the-enemy-1767251112.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 7 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/the-psychology-of-money-1767327972.pdf') }}">
                <img
                  src="{{ asset('img/psychologyofmoney.png') }}"
                  alt="The Psychology of Money"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>The Psychology of Money</h3>
              <p class="author">By: Morgan Housel</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-psychology-of-money-1767327972.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 8 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/good-vibes-good-life-how-self-love-is-the-key-to-unlocking-your-greatness-1777269041.pdf') }}"
              >
                <img
                  src="{{ asset('img/good.png') }}"
                  alt="Good Vibes Good Life: How Self-Love Is the Key to"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>Good Vibes Good Life: How Self-Love Is the Key to</h3>
              <p class="author">By: Vex King</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['good-vibes-good-life-how-self-love-is-the-key-to-unlocking-your-greatness-1777269041.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 9 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/surrounded-by-liars-how-to-stop-half-truths-deception-and-gaslighting-from-ruining-your-life-1767261315.pdf') }}"
              >
                <img
                  src="{{ asset('img/byliars.png') }}"
                  alt="Surrounded by Liars: How to Stop Half-Truths,"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>Surrounded by Liars: How to Stop Half-Truths,</h3>
              <p class="author">By: Thomas Erikson</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['surrounded-by-liars-how-to-stop-half-truths-deception-and-gaslighting-from-ruining-your-life-1767261315.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 10 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/the-laws-of-human-nature-1777265971.pdf') }}">
                <img
                  src="{{ asset('img/lawsofhuman.png') }}"
                  alt="The Laws of Human Nature"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>The Laws of Human Nature</h3>
              <p class="author">By: Robert Greene</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-laws-of-human-nature-1777265971.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 11 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/stop-letting-everything-affect-you-how-to-break-free-from-overthinking-emotional-chaos-and-self-sabotage-1774925795.pdf') }}"
              >
                <img
                  src="{{ asset('img/stopletting.png') }}"
                  alt="Stop Letting Everything Affect You: How to break"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>Stop Letting Everything Affect You: How to break</h3>
              <p class="author">By: Daniel Chidiac</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['stop-letting-everything-affect-you-how-to-break-free-from-overthinking-emotional-chaos-and-self-sabotage-1774925795.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 12 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/your-next-five-moves-master-the-art-of-business-strategy-1775188342.pdf') }}"
              >
                <img
                  src="{{ asset('img/yournext.png') }}"
                  alt="Your Next Five Moves: Master the Art of Business"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>Your Next Five Moves: Master the Art of Business</h3>
              <p class="author">By: Patrick Bet-David</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['your-next-five-moves-master-the-art-of-business-strategy-1775188342.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 13 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/mattering-the-secret-to-a-life-of-deep-connection-and-purpose-1770019657.pdf') }}"
              >
                <img
                  src="{{ asset('img/matterng.png') }}"
                  alt="Mattering: The Secret to a Life of Deep"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>Mattering: The Secret to a Life of Deep</h3>
              <p class="author">By: Jennifer Breheny Wallace</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['mattering-the-secret-to-a-life-of-deep-connection-and-purpose-1770019657.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 14 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/the-art-of-seduction-1774330295.pdf') }}">
                <img src="{{ asset('img/seduction.png') }}" alt="The Art of Seduction" />
              </a>
            </div>
            <div class="card-info">
              <h3>The Art of Seduction</h3>
              <p class="author">By: Robert Greene</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-art-of-seduction-1774330295.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 15 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/the-subtle-art-of-not-giving-a-fuck-1774837859.pdf') }}"
              >
                <img
                  src="{{ asset('img/notgaf.png') }}"
                  alt="The Subtle Art of Not Giving a Fuck"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>The Subtle Art of Not Giving a Fuck</h3>
              <p class="author">By: Mark Manson</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-subtle-art-of-not-giving-a-fuck-1774837859.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 16 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a
                href="{{ url('book/the-mountain-is-you-transforming-self-sabotage-into-self-mastery-1775457883.pdf') }}"
              >
                <img
                  src="{{ asset('img/themountain.png') }}"
                  alt="The Mountain Is You Transforming Self-"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>The Mountain Is You Transforming Self-</h3>
              <p class="author">By: Brianna Wiest</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-mountain-is-you-transforming-self-sabotage-into-self-mastery-1775457883.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 17 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/what-are-you-doing-with-your-life-1767510220.pdf') }}">
                <img
                  src="{{ asset('img/wydwurlife.png') }}"
                  alt="What Are You Doing With Your Life?"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>What Are You Doing With Your Life?</h3>
              <p class="author">By: J. Krishnamurti</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['what-are-you-doing-with-your-life-1767510220.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
          <!-- Card 18 -->
          <article class="mini-book-card">
            <div class="card-cover">
              <a href="{{ url('book/the-art-of-being-alone-solitude-is-my-home-loneliness-was-my-cage-1768100883.pdf') }}">
                <img
                  src="{{ asset('img/alone.png') }}"
                  alt="The Art of Being ALONE: Solitude Is My HOME"
                />
              </a>
            </div>
            <div class="card-info">
              <h3>The Art of Being ALONE: Solitude Is My HOME</h3>
              <p class="author">By: Renuka Gavrani</p>
              <div class="card-footer">
                <span class="views">👁 {{ number_format($bookViews['the-art-of-being-alone-solitude-is-my-home-loneliness-was-my-cage-1768100883.pdf'] ?? 0) }}</span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>
  </body>
</html>
