<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Get all tasks with categories
        $tasks = DB::table('tasks')->whereNotNull('categories')->get();
        
        foreach ($tasks as $task) {
            $categories = json_decode($task->categories, true);
            if (!$categories) continue;
            
            foreach ($categories as $categoryData) {
                // Create category if it doesn't exist
                $category = DB::table('categories')->where('name', $categoryData['label'])->first();
                if (!$category) {
                    $categoryId = DB::table('categories')->insertGetId([
                        'user_id' => 1, // Default user for existing data
                        'name' => $categoryData['label'],
                        'color' => $categoryData['color'] ?? 'gray',
                        'icon' => $categoryData['icon'] ?? 'tag',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $categoryId = $category->id;
                }
                
                // Link task to category
                DB::table('task_categories')->insertOrIgnore([
                    'task_id' => $task->id,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Remove all task-category relationships
        DB::table('task_categories')->truncate();
        DB::table('categories')->truncate();
    }
};
