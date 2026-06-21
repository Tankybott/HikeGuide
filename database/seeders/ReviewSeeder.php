<?php

namespace Database\Seeders;

use App\Models\Hike;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = $this->createUsers();

        $trolltunga = Hike::where('title', 'Trolltunga Trek')->firstOrFail();
        $rysy       = Hike::where('title', 'Rysy Summit Trail')->firstOrFail();

        // --- 6 reviews on Trolltunga Trek ---

        $this->review($trolltunga, $users[0], 5,
            'Absolutely breathtaking experience. The hike itself is long but every single step is worth it. The rock formation hanging over the fjord is unlike anything I have ever seen. Go early to beat the crowds.',
            ['photos/lake.jpg', 'photos/trail.jpg'],
        );

        $this->review($trolltunga, $users[1], 4,
            'One of the best hikes I have done in Scandinavia. The trail is well marked and the scenery keeps getting better. Bring enough food and water because there are no shops along the way.',
            ['photos/peak.jpg'],
        );

        $this->review($trolltunga, $users[2], 3,
            'Beautiful destination but the trail is heavily trafficked in summer. We started at 5am and still passed hundreds of people on the way. The views at the top are genuinely spectacular though.',
            [],
        );

        $this->review($trolltunga, $users[3], 5,
            'We did this on a clear October day and had the rock nearly to ourselves. The autumn colours made everything even more magical. Highly recommend going off-season if you can manage it.',
            ['photos/mountain.jpg', 'photos/hallstatt.jpg'],
        );

        $this->review($trolltunga, $users[4], 4,
            'Great hike with some steep sections near the end. Trekking poles are a big help on the descent. The fjord views on the way up already make the effort worthwhile before you even reach the top.',
            [],
        );

        $this->review($trolltunga, $users[5], 2,
            'Overrated in my opinion. The walk is very long for what you get and the path is packed with tourists. Views are nice but you can find equally good scenery on quieter trails nearby.',
            ['photos/forest.jpg'],
        );

        // --- 3 reviews on Rysy Summit Trail ---

        $this->review($rysy, $users[0], 5,
            'Rysy is the crown jewel of the Polish Tatras. The summit ridge is exposed and a little scary but the 360 degree panorama is simply incredible. One of my all time favourite hikes.',
            ['photos/peak.jpg'],
        );

        $this->review($rysy, $users[1], 4,
            'Challenging climb with some scrambling near the top. The chains and fixed ropes make it manageable but you need a good head for heights. Start very early to avoid afternoon thunderstorms.',
            [],
        );

        $this->review($rysy, $users[2], 3,
            'Tough but rewarding. The trail is rocky and demanding and you need proper boots. Weather can change very fast up here so pack a rain jacket even on sunny days.',
            ['photos/trail.jpg'],
        );
    }

    private function createUsers(): array
    {
        $data = [
            ['nickname' => 'john_peaks',    'email' => 'john@hikeexample.com'],
            ['nickname' => 'sarah_trails',  'email' => 'sarah@hikeexample.com'],
            ['nickname' => 'mike_summit',   'email' => 'mike@hikeexample.com'],
            ['nickname' => 'emma_wanders',  'email' => 'emma@hikeexample.com'],
            ['nickname' => 'david_alpine',  'email' => 'david@hikeexample.com'],
            ['nickname' => 'lisa_outdoors', 'email' => 'lisa@hikeexample.com'],
        ];

        return array_map(fn($d) => User::create([
            'nickname'          => $d['nickname'],
            'email'             => $d['email'],
            'password'          => 'password',
            'email_verified_at' => now(),
        ]), $data);
    }

    private function review(Hike $hike, User $user, int $rate, string $message, array $photos): void
    {
        $review = $hike->reviews()->create([
            'user_id' => $user->id,
            'message' => $message,
            'rate'    => $rate,
        ]);

        foreach ($photos as $path) {
            $review->photos()->create(['path' => $path, 'is_main' => false]);
        }
    }
}
