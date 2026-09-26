<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/*
| NOTE: TrackVisit — កត់ត្រាការចូលមើល page
|
| តួនាទី៖ រាល់ពេលមាននរណាម្នាក់បើក page (GET ហើយជោគជ័យ) វារក្សាទុក IP, page, browser
|         ចូល table visits។
|
| ភ្ជាប់ពី file៖
|   - routes/web.php          → ដាក់លើ route /, /second, /third, /about
|
| ភ្ជាប់ទៅ file៖
|   - app/Models/Visit.php    → ប្រើ Visit::create() ដើម្បីរក្សាទុក
|   - database/migrations/2026_09_14_000000_create_visits_table.php → បង្កើត table visits
*/
class TrackVisit
{
    /**
     * Record each page view (IP, page, browser) in the visits table.
     */
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
}
