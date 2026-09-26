<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

/*
| NOTE: indexcontroller — បញ្ជូន view ទៅ browser
|
| តួនាទី៖ method នីមួយៗត្រឡប់ view មួយ។ method visits() គណនាស្ថិតិអ្នកចូលមើល។
|         method book() ប្តូរទិសទៅ PDF (TrackVisit កត់ត្រា view មុន)។
|
| ភ្ជាប់ពី file៖
|   - routes/web.php                                 → ហៅ method ទាំងអស់ក្នុង file នេះ
|
| ភ្ជាប់ទៅ file៖
|   - app/Models/Visit.php                           → អានទិន្នន័យពី table visits (ក្នុង home(), library() និង visits())
|   - resources/views/backend/html/index.blade.php       ← home()        ($totalVisitors)
|   - resources/views/backend/html/library.blade.php     ← library()     ($bookViews)
|   - resources/views/backend/html/bookdetails.blade.php ← bookdetails()
|   - resources/views/backend/html/about.blade.php       ← about()
|   - resources/views/backend/html/visits.blade.php      ← visits()
|   - public/pdf/{file}                                  ← book() ប្តូរទិសទៅ
*/
class indexcontroller extends Controller
{
    public function visits(){
        return view('backend.html.visits', [
            'total' => Visit::count(),
            'unique' => Visit::distinct()->count('ip'),
            'today' => Visit::whereDate('created_at', today())->count(),
            'byPage' => Visit::selectRaw('path, COUNT(*) as views, COUNT(DISTINCT ip) as visitors')
                ->groupBy('path')
                ->orderByDesc('views')
                ->get(),
            'recent' => Visit::latest()->take(50)->get(),
        ]);
    }

    public function home(){
        return view('backend.html.index', [
            'totalVisitors' => Visit::count(),
        ]);
    }

    public function library(){
        // ចំនួន view សៀវភៅនីមួយៗ៖ [ 'file.pdf' => ចំនួន ]
        $bookViews = Visit::where('path', 'like', '/book/%')
            ->selectRaw('path, COUNT(*) as views')
            ->groupBy('path')
            ->pluck('views', 'path')
            ->mapWithKeys(fn ($views, $path) => [basename($path) => $views]);

        return view('backend.html.library', [
            'bookViews' => $bookViews,
        ]);
    }

    public function book(string $file){
        abort_unless(is_file(public_path('pdf/'.$file)), 404);

        return redirect(asset('pdf/'.$file));
    }

    public function bookdetails(){
        return view('backend.html.bookdetails');
    }

    public function about(){
        return view('backend.html.about');
    }
}
