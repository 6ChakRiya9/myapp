# ការបន្ថែមមុខងារ TOTAL VISITORS និង Views 👁 លើ Card សៀវភៅ

Project: `myapp` (ShelfControl) · កាលបរិច្ឆេទ: 14 កញ្ញា 2026

---

## សង្ខេប

| មុខងារ | មុនកែ | ក្រោយកែ |
|---|---|---|
| **TOTAL VISITORS** (Home `/`) | លេខ `81,006` សរសេរដាក់ផ្ទាល់ មិនឡើង | ចំនួនពិតពី database ឡើង ១ រាល់ពេលបើក page ឬចុចសៀវភៅ |
| **Views 👁** (Card ក្នុង Library `/second`) | លេខ `1,630`, `1,485`, `867`... សរសេរដាក់ផ្ទាល់ | ចំនួនពិតនៃការចុចសៀវភៅនីមួយៗ |
| ចុចសៀវភៅ | បើក PDF ដោយផ្ទាល់ (Laravel មិនដឹង) | ឆ្លងកាត់ `/book/{file}` → កត់ត្រា → បើក PDF |

---

## លំហូរដំណើរការ

```
បើក page (/ , /second, /third, /about)  ឬ  ចុចសៀវភៅ (/book/{file})
        │
        ▼
routes/web.php ──► TrackVisit (middleware) ──► Visit::create() ──► table visits (database.sqlite)
        │                                                              │
        ▼                                                              │ អាន
indexcontroller.php                                                    │
   ├── home()    ── Visit::count() ──────────────────────────────────◄─┤ ──► index.blade.php   (TOTAL VISITORS)
   ├── library() ── រាប់ path /book/% តាមសៀវភៅ ───────────────────────◄─┘ ──► library.blade.php (👁 Views)
   └── book()    ── ប្តូរទិសទៅ public/pdf/{file}
```

---

## File ទាំងអស់ដែលពាក់ព័ន្ធ

| # | File | ស្ថានភាព | សម្រាប់មុខងារ |
|---|---|---|---|
| 1 | `database/migrations/2026_09_14_000000_create_visits_table.php` | 🆕 ថ្មី | ទាំងពីរ |
| 2 | `app/Models/Visit.php` | 🆕 ថ្មី | ទាំងពីរ |
| 3 | `app/Http/Middleware/TrackVisit.php` | 🆕 ថ្មី | ទាំងពីរ |
| 4 | `routes/web.php` | ✏️ កែ | ទាំងពីរ |
| 5 | `app/Http/Controllers/indexcontroller.php` | ✏️ កែ | ទាំងពីរ |
| 6 | `resources/views/backend/html/index.blade.php` | ✏️ កែ | TOTAL VISITORS |
| 7 | `resources/views/backend/html/library.blade.php` | ✏️ កែ | Views 👁 |

> មុខងារបន្ថែម (មិនចាំបាច់សម្រាប់ពីរខាងលើ)៖ `app/Http/Middleware/LocalhostOnly.php` និង
> `resources/views/backend/html/visits.blade.php` សម្រាប់ទំព័រស្ថិតិ `http://127.0.0.1:8000/visits`។

---

## 1. Migration — បង្កើត table `visits` 🆕

**File:** `database/migrations/2026_09_14_000000_create_visits_table.php`
**Run:** `php artisan migrate` (បាន run រួចហើយ)

```php
Schema::create('visits', function (Blueprint $table) {
    $table->id();
    $table->string('ip', 45);             // IP អ្នកចូលមើល
    $table->string('path');               // page ដែលមើល ឧ. /second ឬ /book/xxx.pdf
    $table->text('user_agent')->nullable(); // browser
    $table->timestamps();                 // created_at = ពេលចូលមើល

    $table->index('ip');
    $table->index('path');
    $table->index('created_at');
});
```

---

## 2. Model — `Visit` 🆕

**File:** `app/Models/Visit.php`

```php
class Visit extends Model
{
    protected $fillable = ['ip', 'path', 'user_agent'];
}
```

---

## 3. Middleware — `TrackVisit` 🆕

**File:** `app/Http/Middleware/TrackVisit.php`
**តួនាទី:** កត់ត្រារាល់ការបើក page និងការចុចសៀវភៅ

```php
public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    // isRedirection(): /book/{file} ប្តូរទិសទៅ PDF (302) ក៏ត្រូវរាប់ដែរ
    if ($request->isMethod('GET') && ($response->isSuccessful() || $response->isRedirection())) {
        Visit::create([
            'ip' => $request->ip(),
            'path' => '/'.ltrim($request->path(), '/'),
            'user_agent' => $request->userAgent(),
        ]);
    }

    return $response;
}
```

---

## 4. Routes ✏️

**File:** `routes/web.php`

### មុនកែ
```php
Route::get('/', [indexcontroller::class, 'home']);
Route::get('/second', [indexcontroller::class, 'library']);
Route::get('/third', [indexcontroller::class, 'bookdetails']);
Route::get('/about', [indexcontroller::class, 'about']);
```

### ក្រោយកែ
```php
use App\Http\Middleware\LocalhostOnly;
use App\Http\Middleware\TrackVisit;

Route::middleware(TrackVisit::class)->group(function () {   // ➕ កត់ត្រាការចូលមើល
    Route::get('/', [indexcontroller::class, 'home']);
    Route::get('/second', [indexcontroller::class, 'library']);
    Route::get('/book/{file}', [indexcontroller::class, 'book'])     // ➕ ថ្មី: ចុចសៀវភៅ
        ->where('file', '[A-Za-z0-9._-]+\.pdf');
    Route::get('/third', [indexcontroller::class, 'bookdetails']);
    Route::get('/about', [indexcontroller::class, 'about']);
});

Route::get('/visits', [indexcontroller::class, 'visits'])->middleware(LocalhostOnly::class); // ➕ ទំព័រស្ថិតិ
```

---

## 5. Controller ✏️

**File:** `app/Http/Controllers/indexcontroller.php`

### មុនកែ
```php
public function home(){
    return view('backend.html.index');
}

public function library(){
    return view('backend.html.library');
}
```

### ក្រោយកែ
```php
use App\Models\Visit;   // ➕

// TOTAL VISITORS
public function home(){
    return view('backend.html.index', [
        'totalVisitors' => Visit::count(),   // ➕ ចំនួនសរុបពី table visits
    ]);
}

// Views 👁 លើ card
public function library(){
    // ចំនួន view សៀវភៅនីមួយៗ៖ [ 'file.pdf' => ចំនួន ]
    $bookViews = Visit::where('path', 'like', '/book/%')
        ->selectRaw('path, COUNT(*) as views')
        ->groupBy('path')
        ->pluck('views', 'path')
        ->mapWithKeys(fn ($views, $path) => [basename($path) => $views]);

    return view('backend.html.library', [
        'bookViews' => $bookViews,           // ➕
    ]);
}

// ➕ ថ្មី: ពេលចុចសៀវភៅ
public function book(string $file){
    abort_unless(is_file(public_path('pdf/'.$file)), 404);   // គ្មាន file → 404

    return redirect(asset('pdf/'.$file));                   // បើក PDF
}
```

---

## 6. View Home — TOTAL VISITORS ✏️

**File:** `resources/views/backend/html/index.blade.php` (ប្រហែលបន្ទាត់ 350)

### មុនកែ
```html
<span class="stat-number">81,006</span>
<span class="stat-label">TOTAL VISTERS</span>
```

### ក្រោយកែ
```blade
<span class="stat-number">{{ number_format($totalVisitors) }}</span>
<span class="stat-label">TOTAL VISITORS</span>
```

---

## 7. View Library — Views 👁 លើ Card ✏️

**File:** `resources/views/backend/html/library.blade.php` (Card ទាំង ១៨)

### មុនកែ (ឧទាហរណ៍ Card 1)
```blade
<a href="{{ asset('pdf/the-let-them-theory-1768546359.pdf') }}">
  <img src="{{ asset('img/letthem.png') }}" alt="The Let Them Theory" />
</a>
...
<span class="views">👁 1,630</span>
```

### ក្រោយកែ
```blade
<a href="{{ url('book/the-let-them-theory-1768546359.pdf') }}">
  <img src="{{ asset('img/letthem.png') }}" alt="The Let Them Theory" />
</a>
...
<span class="views">👁 {{ number_format($bookViews['the-let-them-theory-1768546359.pdf'] ?? 0) }}</span>
```

**ការប្តូរដូចគ្នាលើ Card ទាំង ១៨៖**
- `href="{{ asset('pdf/FILE.pdf') }}"` → `href="{{ url('book/FILE.pdf') }}"`
- `👁 1,630` (លេខដាក់ផ្ទាល់) → `👁 {{ number_format($bookViews['FILE.pdf'] ?? 0) }}`
- `?? 0` = បើសៀវភៅមិនទាន់មាននរណាចុច បង្ហាញ 0

---

## លទ្ធផលសាកល្បង

| សាកល្បង | លទ្ធផល |
|---|---|
| បើក Home ៣ ដង | TOTAL VISITORS: **0 → 1 → 2** ✅ |
| 👁 "The Let Them Theory" មុនចុច | **0** ✅ |
| ចុចសៀវភៅ ២ ដង | `302` → `/pdf/the-let-them-theory-1768546359.pdf` ✅ |
| 👁 ក្រោយចុច | **2** ✅ |
| PDF បើកបាន | `200` ✅ |
| `/book/not-a-real-book.pdf` | `404` ✅ |
| ទិន្នន័យសាកល្បង | បានលុបចោល (ចាប់ផ្តើមពី 0) ✅ |

---

## របៀបប្រើ

```bash
php artisan serve
```

- Home (TOTAL VISITORS): http://127.0.0.1:8000
- Library (👁 Views): http://127.0.0.1:8000/second
- ស្ថិតិលម្អិត: http://127.0.0.1:8000/visits (បើកបានតែពី localhost)

---

## ចំណាំ

- **TOTAL VISITORS** រាប់គ្រប់ការកត់ត្រា (បើក page + ចុចសៀវភៅ) ហើយជា *page views* មិនមែនចំនួនមនុស្សទេ។
- លេខនៅ Home បង្ហាញចំនួន **មុន** ការចូលមើលលើកនេះ (ព្រោះកត់ត្រាក្រោយ page បង្ហាញរួច)។
- **👁 Views** រាប់ចំនួនដងចុច — មនុស្សម្នាក់ចុច ៥ ដង = 5។
- លេខចាស់ (81,006, 1,630, ...) ត្រូវបានលុប ចាប់ផ្តើមពី **0**។
- ដើម្បីកំណត់ចំនួនឡើងវិញពី 0៖
  ```bash
  php artisan tinker --execute="App\Models\Visit::query()->delete();"
  ```
