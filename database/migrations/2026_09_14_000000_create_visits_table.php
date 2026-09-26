<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| NOTE: Migration — បង្កើត table visits
|
| តួនាទី៖ បង្កើត table visits ក្នុង database/database.sqlite
|         Run ដោយ៖ php artisan migrate
|
| Column៖ id, ip, path, user_agent, created_at, updated_at
|
| ភ្ជាប់ពី file៖
|   - app/Models/Visit.php    → ប្រើ table នេះ
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45);
            $table->string('path');
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('ip');
            $table->index('path');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
