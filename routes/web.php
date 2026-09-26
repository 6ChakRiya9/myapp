<?php

/*
|--------------------------------------------------------------------------
| NOTE: routes/web.php — កំណត់ URL នៃ website
|--------------------------------------------------------------------------
| តួនាទី៖ ភ្ជាប់ URL នីមួយៗទៅ method ក្នុង controller។
|
| ភ្ជាប់ទៅ file៖
|   - app/Http/Controllers/indexcontroller.php  → method home, library, book, bookdetails, about, visits
|   - app/Http/Middleware/TrackVisit.php         → កត់ត្រាការចូលមើល page ទាំង ៤ និងការចុចសៀវភៅ
|   - app/Http/Middleware/LocalhostOnly.php      → អនុញ្ញាតឲ្យបើក /visits តែពី localhost
|
| URL                 → Method        → View
|   /                 → home()        → resources/views/backend/html/index.blade.php
|   /second           → library()     → resources/views/backend/html/library.blade.php
|   /book/{file}      → book()        → ប្តូរទិសទៅ public/pdf/{file} (រាប់ 👁 view សៀវភៅ)
|   /third            → bookdetails() → resources/views/backend/html/bookdetails.blade.php
|   /about            → about()       → resources/views/backend/html/about.blade.php
|   /visits           → visits()      → resources/views/backend/html/visits.blade.php
*/

use App\Http\Controllers\indexcontroller;
use App\Http\Middleware\LocalhostOnly;
use App\Http\Middleware\TrackVisit;
use Illuminate\Support\Facades\Route;

Route::middleware(TrackVisit::class)->group(function () {
    Route::get('/', [indexcontroller::class, 'home']);
    Route::get('/second', [indexcontroller::class, 'library']);
    Route::get('/book/{file}', [indexcontroller::class, 'book'])->where('file', '[A-Za-z0-9._-]+\.pdf');
    Route::get('/third', [indexcontroller::class, 'bookdetails']);
    Route::get('/about', [indexcontroller::class, 'about']);
});

Route::get('/visits', [indexcontroller::class, 'visits'])->middleware(LocalhostOnly::class);
