<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'ฟรี',
                'slug' => 'free',
                'description' => 'เหมาะสำหรับเริ่มต้นใช้งาน',
                'price' => 0,
                'duration_days' => 30,
                'max_documents' => 50,
                'max_customers' => 50,
                'can_send_line' => false,
                'can_customize_template' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'เหมาะสำหรับธุรกิจขนาดกลาง',
                'price' => 299,
                'duration_days' => 30,
                'max_documents' => 500,
                'max_customers' => 999999,
                'can_send_line' => true,
                'can_customize_template' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'เหมาะสำหรับธุรกิจขนาดใหญ่',
                'price' => 999,
                'duration_days' => 30,
                'max_documents' => 999999,
                'max_customers' => 999999,
                'can_send_line' => true,
                'can_customize_template' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
