{{--
| NOTE: visits.blade.php — ទំព័រស្ថិតិអ្នកចូលមើល (http://127.0.0.1:8000/visits)
|
| តួនាទី៖ បង្ហាញ Total page views, Unique visitors (IP), Views today,
|         ចំនួនមើលតាម page និងការចូលមើល ៥០ ចុងក្រោយ។
|
| ភ្ជាប់ពី file៖
|   - routes/web.php                              → URL /visits
|   - app/Http/Controllers/indexcontroller.php    → method visits() បញ្ជូន $total, $unique, $today, $byPage, $recent
|   - app/Http/Middleware/LocalhostOnly.php       → បើកបានតែពី localhost
|
| ទិន្នន័យមកពី៖
|   - app/Models/Visit.php → table visits ក្នុង database/database.sqlite
--}}
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShelfControl — Visitors</title>
    <style>
      :root {
        --c1-darkest: #06141b;
        --c2-navy: #11212d;
        --c3-slate: #253745;
        --c4-steel: #4a5c6a;
        --c5-silver: #9ba8ab;
        --c6-light: #c3cfdc;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        background-color: var(--c6-light);
        color: var(--c1-darkest);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        line-height: 1.6;
      }

      .site-header {
        background-color: var(--c2-navy);
        border-bottom: 3px solid var(--c4-steel);
        padding: 1rem 1.5rem;
        text-align: center;
      }

      .logo {
        color: var(--c6-light);
        font-size: 1.35rem;
        font-weight: 700;
        text-decoration: none;
      }

      .logo .highlight {
        color: var(--c5-silver);
      }

      .container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 0 1.5rem;
      }

      h1 {
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
      }

      h2 {
        font-size: 1.15rem;
        margin: 2rem 0 0.75rem;
      }

      .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
      }

      .stat {
        background-color: var(--c2-navy);
        color: #ffffff;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
      }

      .stat .number {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.1;
      }

      .stat .label {
        color: var(--c5-silver);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
      }

      .table-wrap {
        overflow-x: auto;
        background-color: #ffffff;
        border-radius: 10px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
      }

      th,
      td {
        text-align: left;
        padding: 0.6rem 1rem;
        border-bottom: 1px solid #e5e9ee;
        white-space: nowrap;
      }

      th {
        background-color: var(--c3-slate);
        color: var(--c6-light);
      }

      td.agent {
        white-space: normal;
        color: var(--c4-steel);
        font-size: 0.8rem;
        min-width: 280px;
      }

      .empty {
        padding: 1rem;
        color: var(--c4-steel);
      }
    </style>
  </head>
  <body>
    <header class="site-header">
      <a href="/" class="logo">Shelf<span class="highlight">Control</span></a>
    </header>

    <main class="container">
      <h1>Visitors</h1>

      <div class="stats">
        <div class="stat">
          <div class="number">{{ number_format($total) }}</div>
          <div class="label">TOTAL PAGE VIEWS</div>
        </div>
        <div class="stat">
          <div class="number">{{ number_format($unique) }}</div>
          <div class="label">UNIQUE VISITORS (IP)</div>
        </div>
        <div class="stat">
          <div class="number">{{ number_format($today) }}</div>
          <div class="label">VIEWS TODAY</div>
        </div>
      </div>

      <h2>Views by page</h2>
      <div class="table-wrap">
        @if ($byPage->isEmpty())
          <p class="empty">No visits yet.</p>
        @else
          <table>
            <thead>
              <tr><th>Page</th><th>Views</th><th>Visitors (IP)</th></tr>
            </thead>
            <tbody>
              @foreach ($byPage as $row)
                <tr>
                  <td>{{ $row->path }}</td>
                  <td>{{ number_format($row->views) }}</td>
                  <td>{{ number_format($row->visitors) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      <h2>Latest 50 visits</h2>
      <div class="table-wrap">
        @if ($recent->isEmpty())
          <p class="empty">No visits yet.</p>
        @else
          <table>
            <thead>
              <tr><th>Time</th><th>IP</th><th>Page</th><th>Browser</th></tr>
            </thead>
            <tbody>
              @foreach ($recent as $visit)
                <tr>
                  <td>{{ $visit->created_at->format('Y-m-d H:i:s') }}</td>
                  <td>{{ $visit->ip }}</td>
                  <td>{{ $visit->path }}</td>
                  <td class="agent">{{ $visit->user_agent }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </main>
  </body>
</html>
