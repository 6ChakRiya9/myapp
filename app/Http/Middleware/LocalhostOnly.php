<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/*
| NOTE: LocalhostOnly — ការពារទំព័រស្ថិតិ
|
| តួនាទី៖ អនុញ្ញាតឲ្យបើកតែពីកុំព្យូទ័រនេះ (IP 127.0.0.1 ឬ ::1)។
|         កុំព្យូទ័រផ្សេងនឹងទទួលបាន error 403។
|
| ភ្ជាប់ពី file៖
|   - routes/web.php          → ដាក់លើ route /visits
|
| ភ្ជាប់ទៅ file៖ គ្មាន
*/
class LocalhostOnly
{
    /**
     * Allow the request only from this computer (localhost).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->ip(), ['127.0.0.1', '::1'], true)) {
            abort(403, 'Visitor stats are only available from localhost.');
        }

        return $next($request);
    }
}
