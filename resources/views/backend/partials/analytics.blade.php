{{--
| NOTE: analytics.blade.php — កូដ Google Analytics
|
| តួនាទី៖ បញ្ចូល script Google Analytics តែពេល GOOGLE_ANALYTICS_ID ក្នុង .env មានតម្លៃ។
|
| ភ្ជាប់ពី file (@include នៅក្នុង <head>)៖
|   - resources/views/backend/html/index.blade.php
|   - resources/views/backend/html/library.blade.php
|   - resources/views/backend/html/bookdetails.blade.php
|   - resources/views/backend/html/about.blade.php
|
| ភ្ជាប់ទៅ file៖
|   - config/services.php → google_analytics.id
|   - .env                → GOOGLE_ANALYTICS_ID
--}}
@if (config('services.google_analytics.id'))
    <!-- Google Analytics (GA4) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json(config('services.google_analytics.id')));
    </script>
@endif
