<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user to assign as creator
        $adminUser = User::where('role', 'admin')->first();
        $createdBy = $adminUser ? $adminUser->id : null;

        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'title' => 'Regular Customer',
                'content' => 'Absolutely amazing food and lightning-fast delivery! The grilled chicken was perfectly seasoned and the truffle fries were to die for. Will definitely be ordering again soon.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Michael Chen',
                'title' => 'Wedding Client',
                'content' => 'Foodymat catered our wedding and it was absolutely perfect! The food was exceptional and the service was flawless. All our guests raved about the meal. Highly recommend!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Emma Rodriguez',
                'title' => 'Health Enthusiast',
                'content' => 'As a vegetarian, I appreciate the variety of plant-based options. The quinoa-stuffed peppers are incredible and the salads are always fresh. Great healthy choices!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'David Thompson',
                'title' => 'Business Owner',
                'content' => 'I order from Foodymat for all my corporate meetings. The food is always fresh, arrives on time, and impresses my clients. Professional service every time.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 4,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Jennifer Wilson',
                'title' => 'Food Blogger',
                'content' => 'The best food delivery service in town! Quality ingredients, creative dishes, and excellent customer service. The Maryland crab cakes are restaurant-quality.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 5,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'James Martinez',
                'title' => 'Family Man',
                'content' => 'Perfect for family dinners! The kids love the pizza and my wife adores the gourmet salads. Great variety for everyone in the family.',
                'rating' => 4,
                'is_active' => true,
                'sort_order' => 6,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Lisa Anderson',
                'title' => 'Office Manager',
                'content' => 'We order lunch for our office every Friday and Foodymat never disappoints. Always on time, always delicious. Our team looks forward to it every week!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 7,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Robert Kim',
                'title' => 'Food Lover',
                'content' => 'Exceptional quality and taste! The seafood pasta is my absolute favorite. I\'ve tried many delivery services, but none compare to Foodymat.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 8,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Maria Garcia',
                'title' => 'College Student',
                'content' => 'Great value for money and the portions are generous. Perfect for a student budget and the quality is still amazing. My go-to for late-night study sessions!',
                'rating' => 4,
                'is_active' => true,
                'sort_order' => 9,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Thomas Brown',
                'title' => 'Chef',
                'content' => 'As a professional chef, I\'m very particular about food quality. Foodymat consistently delivers restaurant-quality meals. Impressive presentation and flavors!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 10,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Amanda Taylor',
                'title' => 'Busy Mom',
                'content' => 'Lifesaver for busy weeknights! The family meals are perfect and save me so much time. Kids are happy, and I don\'t have to stress about cooking.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 11,
                'created_by' => $createdBy,
            ],
            [
                'name' => 'Kevin Walsh',
                'title' => 'Fitness Trainer',
                'content' => 'Love the healthy options and nutritional information provided. Perfect for maintaining my diet goals while still enjoying delicious food.',
                'rating' => 4,
                'is_active' => true,
                'sort_order' => 12,
                'created_by' => $createdBy,
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $this->command->info('Testimonials seeded successfully!');
    }
}