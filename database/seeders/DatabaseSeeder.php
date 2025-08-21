<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        // Create regular user
        $regularUser = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $userRole->id,
        ]);

        // Create additional users using factory
        $users = User::factory(8)->create(['role_id' => $userRole->id]);

        // Create categories
        $categories = [
            'Electronics' => [
                'Smartphones & Phones', 'Laptops & Computers', 'Tablets & iPads', 'Headphones & Audio', 'Cameras & Photography', 'Gaming & Consoles'
            ],
            'Clothing & Fashion' => [
                'Men\'s Apparel', 'Women\'s Apparel', 'Kids & Children', 'Footwear & Shoes', 'Accessories & Jewelry'
            ],
            'Home & Garden' => [
                'Furniture & Decor', 'Kitchen & Appliances', 'Garden & Outdoor', 'Home Improvement', 'Lighting & Fixtures'
            ],
            'Sports & Outdoors' => [
                'Fitness & Exercise', 'Camping & Hiking', 'Bicycles & Cycling', 'Team Sports', 'Water Sports'
            ],
            'Books & Media' => [
                'Fiction & Literature', 'Non-Fiction & Educational', 'Children\'s Books', 'Movies & DVDs', 'Music & CDs'
            ],
            'Beauty & Health' => [
                'Skincare & Cosmetics', 'Makeup & Beauty', 'Fragrances & Perfumes', 'Health & Wellness', 'Personal Care'
            ],
            'Automotive & Vehicles' => [
                'Car Parts & Accessories', 'Motorcycle Gear', 'Tools & Equipment', 'Car Care & Maintenance', 'Vehicle Electronics'
            ],
            'Toys & Games' => [
                'Board Games & Puzzles', 'Action Figures & Collectibles', 'Educational Toys', 'Video Games', 'Outdoor Toys'
            ],
            'Food & Beverages' => [
                'Organic & Natural Foods', 'Beverages & Drinks', 'Snacks & Treats', 'Cooking & Ingredients', 'Health Supplements'
            ],
            'Jewelry & Watches' => [
                'Necklaces & Pendants', 'Rings & Bands', 'Earrings & Studs', 'Watches & Timepieces', 'Bracelets & Bangles'
            ]
        ];

        $createdCategories = [];
        foreach ($categories as $mainCategory => $subCategories) {
            $mainCat = Category::create(['name' => $mainCategory]);
            $createdCategories[] = $mainCat;
            
            foreach ($subCategories as $subCategory) {
                Category::create([
                    'name' => $subCategory,
                    'parent_id' => $mainCat->id
                ]);
            }
        }

        // Create sample posts/products
        $allUsers = collect([$adminUser, $regularUser])->merge($users);
        
        // Create posts with realistic data
        Post::factory(50)->create([
            'user_id' => $allUsers->random()->id,
            'category_id' => $createdCategories[array_rand($createdCategories)]->id,
        ]);

        // Create some specific featured products
        $featuredPosts = [
            [
                'thumbnail' => 'https://picsum.photos/400/300?random=1001',
                'title' => 'Premium Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation, perfect for music lovers and professionals. Features include 30-hour battery life, premium sound quality, and comfortable over-ear design.',
                'quantity' => 25,
                'price' => 299.99,
                'category_id' => $createdCategories[0]->id, // Electronics
                'user_id' => $adminUser->id,
            ],
            [
                'thumbnail' => 'https://picsum.photos/400/300?random=1002',
                'title' => 'Organic Cotton T-Shirt Collection',
                'description' => 'Sustainable and comfortable organic cotton t-shirts available in multiple colors and sizes. Perfect for everyday wear with a modern, minimalist design.',
                'quantity' => 100,
                'price' => 29.99,
                'category_id' => $createdCategories[1]->id, // Clothing & Fashion
                'user_id' => $regularUser->id,
            ],
            [
                'thumbnail' => 'https://picsum.photos/400/300?random=1003',
                'title' => 'Smart Home Security Camera',
                'description' => '1080p HD security camera with night vision, motion detection, and two-way audio. Connects to your smartphone for remote monitoring and peace of mind.',
                'quantity' => 15,
                'price' => 149.99,
                'category_id' => $createdCategories[2]->id, // Home & Garden
                'user_id' => $adminUser->id,
            ],
            [
                'thumbnail' => 'https://picsum.photos/400/300?random=1004',
                'title' => 'Professional Yoga Mat',
                'description' => 'Premium non-slip yoga mat made from eco-friendly materials. Perfect thickness for comfort during practice, with alignment lines for proper positioning.',
                'quantity' => 50,
                'price' => 79.99,
                'category_id' => $createdCategories[3]->id, // Sports & Outdoors
                'user_id' => $regularUser->id,
            ],
            [
                'thumbnail' => 'https://picsum.photos/400/300?random=1005',
                'title' => 'Bestselling Fiction Novel',
                'description' => 'Award-winning fiction novel that has captivated readers worldwide. Engaging plot with complex characters and beautiful prose that will keep you turning pages.',
                'quantity' => 200,
                'price' => 19.99,
                'category_id' => $createdCategories[4]->id, // Books & Media
                'user_id' => $adminUser->id,
            ]
        ];

        foreach ($featuredPosts as $postData) {
            Post::create($postData);
        }

        // Create some posts with specific states
        Post::factory(10)->lowStock()->create([
            'user_id' => $allUsers->random()->id,
            'category_id' => $createdCategories[array_rand($createdCategories)]->id,
        ]);

        Post::factory(5)->outOfStock()->create([
            'user_id' => $allUsers->random()->id,
            'category_id' => $createdCategories[array_rand($createdCategories)]->id,
        ]);

        Post::factory(15)->expensive()->create([
            'user_id' => $allUsers->random()->id,
            'category_id' => $createdCategories[array_rand($createdCategories)]->id,
        ]);

        Post::factory(20)->affordable()->create([
            'user_id' => $allUsers->random()->id,
            'category_id' => $createdCategories[array_rand($createdCategories)]->id,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . User::count() . ' users');
        $this->command->info('- ' . Category::count() . ' categories');
        $this->command->info('- ' . Post::count() . ' posts');
        $this->command->info('');
        $this->command->info('Admin credentials: admin@example.com / password');
        $this->command->info('User credentials: user@example.com / password');
    }
}
