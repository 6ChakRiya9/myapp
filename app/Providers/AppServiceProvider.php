<?php

namespace App\Providers;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\ServiceProvider;

/*
| NOTE: AppServiceProvider — ការកំណត់ពេល Laravel ចាប់ផ្តើម
|
| តួនាទី៖ ជួសជុល error "Failed to listen ... (reason: ?)" ពេល run `php artisan serve` លើ Windows។
|         Laravel ប្រៀបធៀបឈ្មោះ env variable ដោយប្រកាន់អក្សរធំ/តូច ('SYSTEMROOT')
|         ប៉ុន្តែ Windows ប្រើ 'SystemRoot' ដូច្នេះត្រូវបន្ថែមឈ្មោះនេះ។
|
| ភ្ជាប់ទៅ file៖
|   - vendor/laravel/framework/src/Illuminate/Foundation/Console/ServeCommand.php (មិនបានកែ file នេះទេ)
*/
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Windows: `php artisan serve` filters env vars case-sensitively, so "SystemRoot"
        // is dropped and the server fails with "Failed to listen ... (reason: ?)".
        if (PHP_OS_FAMILY === 'Windows') {
            ServeCommand::$passthroughVariables = array_merge(
                ServeCommand::$passthroughVariables,
                ['SystemRoot', 'windir', 'TEMP', 'TMP']
            );
        }
    }
}
