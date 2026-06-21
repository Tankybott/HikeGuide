<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // --- Regions ---

        // Tatra Mountains — 3 photos
        $tatra = \App\Models\Region::create([
            'name'              => 'Tatra Mountains',
            'country'           => 'PL',
            'short_description' => 'The highest range of the Carpathians, straddling Poland and Slovakia.',
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);
        $tatra->photos()->createMany([
            ['path' => 'photos/mountain.jpg', 'is_main' => true],
            ['path' => 'photos/peak.jpg',     'is_main' => false],
            ['path' => 'photos/trail.jpg',    'is_main' => false],
        ]);

        // Norwegian Fjords — 2 photos
        $fjords = \App\Models\Region::create([
            'name'              => 'Norwegian Fjords',
            'country'           => 'NO',
            'short_description' => 'Dramatic glacially carved inlets flanked by towering cliffs.',
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra.',
        ]);
        $fjords->photos()->createMany([
            ['path' => 'photos/lake.jpg',     'is_main' => true],
            ['path' => 'photos/hallstatt.jpg','is_main' => false],
        ]);

        // Dolomites — 1 photo
        $dolomites = \App\Models\Region::create([
            'name'              => 'Dolomites',
            'country'           => 'IT',
            'short_description' => 'Jagged limestone peaks and alpine meadows in northern Italy.',
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis molestie dictum semper, metus mauris porttitor sapien, non faucibus lacus tortor eu ipsum. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.',
        ]);
        $dolomites->photos()->create(['path' => 'photos/forest.jpg', 'is_main' => true]);

        // Scottish Highlands — 0 photos
        $highlands = \App\Models\Region::create([
            'name'              => 'Scottish Highlands',
            'country'           => 'GB',
            'short_description' => 'Rugged moorland, ancient glens, and remote mountain summits.',
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi in ipsum sit amet pede facilisis laoreet. Morbi lobortis. Nullam semper. Praesent vel arcu ut tortor cursus facilisis. Etiam bibendum elit eget erat. Sed cursus turpis vitae arcu. Sed molestie augue sit amet leo consequat posuere.',
        ]);

        // --- Hikes ---

        // Rysy Summit — 2 photos
        $tatra->hikes()->create([
            'title'                    => 'Rysy Summit Trail',
            'description'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.',
            'difficulty'               => 'hard',
            'length_km'                => 12.5,
            'has_parking'              => true,
            'is_parking_free'          => false,
            'needs_climbing_equipment' => true,
            'needs_helmet'             => true,
        ])->photos()->createMany([
            ['path' => 'photos/peak.jpg',    'is_main' => true],
            ['path' => 'photos/trail.jpg',   'is_main' => false],
        ]);

        // Black Lake Loop — 0 photos
        $tatra->hikes()->create([
            'title'                    => 'Black Lake Loop',
            'description'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui. Vestibulum facilisis, purus nec pulvinar iaculis, ligula mi congue nunc, vitae euismod ligula urna in dolor.',
            'difficulty'               => 'easy',
            'length_km'                => 6.2,
            'has_parking'              => true,
            'is_parking_free'          => true,
            'needs_climbing_equipment' => false,
            'needs_helmet'             => false,
        ]);

        // Trolltunga Trek — 1 photo
        $fjords->hikes()->create([
            'title'                    => 'Trolltunga Trek',
            'description'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum mi sit amet tortor. Maecenas vehicula odio at mauris. Proin rhoncus consequat felis. Pellentesque dapibus suscipit ligula. Donec est augue, porttitor aliquam, rutrum et, imperdiet vel, pede.',
            'difficulty'               => 'hard',
            'length_km'                => 22.0,
            'has_parking'              => true,
            'is_parking_free'          => false,
            'needs_climbing_equipment' => false,
            'needs_helmet'             => false,
        ])->photos()->create(['path' => 'photos/lake.jpg', 'is_main' => true]);

        // Preikestolen Ascent — 1 photo
        $fjords->hikes()->create([
            'title'                    => 'Preikestolen Ascent',
            'description'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices nulla quis nibh.',
            'difficulty'               => 'moderate',
            'length_km'                => 3.8,
            'has_parking'              => true,
            'is_parking_free'          => true,
            'needs_climbing_equipment' => false,
            'needs_helmet'             => false,
        ])->photos()->create(['path' => 'photos/hallstatt.jpg', 'is_main' => true]);

        // Tre Cime Circuit — 0 photos
        $dolomites->hikes()->create([
            'title'                    => 'Tre Cime Circuit',
            'description'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla, et sollicitudin sem purus in lacus. Vivamus at diam mi ut mi scelerisque laoreet. Phasellus ultrices nulla quis nibh.',
            'difficulty'               => 'moderate',
            'length_km'                => 9.7,
            'has_parking'              => false,
            'is_parking_free'          => false,
            'needs_climbing_equipment' => false,
            'needs_helmet'             => false,
        ]);

        // Ben Nevis Summit — 0 photos
        $highlands->hikes()->create([
            'title'                    => 'Ben Nevis Summit',
            'description'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum. Nullam varius nulla facilisi. Cras a quam. Etiam bibendum elit eget erat. Sed cursus turpis vitae arcu. Integer vulputate sem a nibh rutrum consequat.',
            'difficulty'               => 'hard',
            'length_km'                => 15.2,
            'has_parking'              => true,
            'is_parking_free'          => true,
            'needs_climbing_equipment' => false,
            'needs_helmet'             => false,
        ]);
    }
}
