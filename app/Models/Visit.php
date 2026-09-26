<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
| NOTE: Visit — Model សម្រាប់ table visits
|
| តួនាទី៖ តំណាងឲ្យការចូលមើលម្ដងៗ (ip, path, user_agent, created_at)។
|
| ភ្ជាប់ពី file៖
|   - app/Http/Middleware/TrackVisit.php          → បញ្ចូលទិន្នន័យ (Visit::create)
|   - app/Http/Controllers/indexcontroller.php    → អានទិន្នន័យ (ក្នុង visits())
|
| ភ្ជាប់ទៅ file៖
|   - database/migrations/2026_09_14_000000_create_visits_table.php → រចនាសម្ព័ន្ធ table
|   - database/database.sqlite                    → កន្លែងរក្សាទុកទិន្នន័យពិត (DB_CONNECTION=sqlite ក្នុង .env)
*/
class Visit extends Model
{
    protected $fillable = ['ip', 'path', 'user_agent'];
}
