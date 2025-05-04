<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\Reaction;

class ReactionSeeder extends Seeder
{
    public function run()
    {
        // get quotes in random order
        $quotes = Quote::inRandomOrder()->get();
        $emojis = ['😂', '😍', '🔥', '😢', '😡'];

        foreach ($quotes as $quote) {
            // Random count between 0 and 50 with lower bias for larger numbers
            $numReactions = $this->getRandomReactionCount(50);

            // Add random reactions to each quote
            for ($i = 0; $i < $numReactions; $i++) {
                $randomEmoji = $emojis[array_rand($emojis)];  // Pick a random emoji
                Reaction::create([
                    'quote_id' => $quote->id,
                    'emoji' => $randomEmoji,
                ]);
            }
            $this->command->info('Added ' . $numReactions . ' reactions to quote ID: ' . $quote->id);
        }

        $this->command->info('All reactions have been added successfully!');
        $this->command->info('Total reactions added: ' . Reaction::count());
    }

    // Function to return a random number of reactions with a bias for lower numbers
    private function getRandomReactionCount($max)
    {
        // Generate a random number between 0 and max
        $reactionCount = rand(0, $max);

        // Apply a bias by using a square root to make higher numbers less likely
        $reactionCount = sqrt($reactionCount) * 5; // Adjust multiplier to get better distribution

        // Ensure that the number is within the range of 0 to $max
        return min((int)$reactionCount, $max);
    }
}