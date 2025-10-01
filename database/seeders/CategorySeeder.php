<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorySystem = [
            'types' => [
                'work' => [
                    'label' => 'Work',
                    'color' => 'blue',
                    'icon' => 'briefcase'
                ],
                'personal' => [
                    'label' => 'Personal',
                    'color' => 'green',
                    'icon' => 'user'
                ],
                'family' => [
                    'label' => 'Family',
                    'color' => 'pink',
                    'icon' => 'users'
                ],
                'health' => [
                    'label' => 'Health',
                    'color' => 'red',
                    'icon' => 'heart'
                ],
                'finance' => [
                    'label' => 'Finance',
                    'color' => 'yellow',
                    'icon' => 'dollar-sign'
                ],
                'education' => [
                    'label' => 'Education',
                    'color' => 'purple',
                    'icon' => 'book'
                ],
                'hobbies' => [
                    'label' => 'Hobbies',
                    'color' => 'orange',
                    'icon' => 'palette'
                ],
                'social' => [
                    'label' => 'Social',
                    'color' => 'cyan',
                    'icon' => 'users'
                ]
            ],
            'priorities' => [
                'urgent' => [
                    'label' => 'Urgent',
                    'level' => 4,
                    'color' => 'red',
                    'icon' => 'alert-triangle'
                ],
                'high' => [
                    'label' => 'High',
                    'level' => 3,
                    'color' => 'orange',
                    'icon' => 'arrow-up'
                ],
                'medium' => [
                    'label' => 'Medium',
                    'level' => 2,
                    'color' => 'yellow',
                    'icon' => 'minus'
                ],
                'low' => [
                    'label' => 'Low',
                    'level' => 1,
                    'color' => 'green',
                    'icon' => 'arrow-down'
                ]
            ],
            'tags' => [
                'deadline' => [
                    'label' => 'Deadline',
                    'color' => 'red',
                    'icon' => 'clock'
                ],
                'meeting' => [
                    'label' => 'Meeting',
                    'color' => 'blue',
                    'icon' => 'calendar'
                ],
                'project' => [
                    'label' => 'Project',
                    'color' => 'purple',
                    'icon' => 'folder'
                ],
                'routine' => [
                    'label' => 'Routine',
                    'color' => 'gray',
                    'icon' => 'repeat'
                ],
                'creative' => [
                    'label' => 'Creative',
                    'color' => 'pink',
                    'icon' => 'sparkles'
                ],
                'urgent' => [
                    'label' => 'Urgent',
                    'color' => 'red',
                    'icon' => 'zap'
                ],
                'review' => [
                    'label' => 'Review',
                    'color' => 'yellow',
                    'icon' => 'eye'
                ],
                'planning' => [
                    'label' => 'Planning',
                    'color' => 'cyan',
                    'icon' => 'map'
                ]
            ]
        ];

        // Store the sophisticated category system in config
        config(['app.task_category_system' => $categorySystem]);
    }
}