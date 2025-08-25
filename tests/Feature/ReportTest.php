<?php

namespace Tests\Feature;

use App\Http\Constants\UserRoleConstant;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports_index_with_metrics(): void
    {
        $admin = User::factory()->create(['role' => UserRoleConstant::ADMIN]);
        $restaurant = Restaurant::factory()->create();

        // Seed a couple of orders in current month
        Order::factory()->create([
            'user_id' => $admin->id,
            'restaurant_id' => $restaurant->id,
            'status' => 'completed',
            'total_amount' => 1000,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        Order::factory()->create([
            'user_id' => $admin->id,
            'restaurant_id' => $restaurant->id,
            'status' => 'confirmed',
            'total_amount' => 500,
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $response = $this->actingAs($admin)->get(route('reports.index'));
        $response->assertOk();
        $response->assertViewIs('dashboard.reports.index');
        $response->assertViewHasAll([
            'totalOrders', 'totalRevenue', 'averageOrderValue', 'completionRate',
            'revenueGrowth', 'topRestaurants', 'dailySales', 'statusDistribution',
            'restaurants', 'startDate', 'endDate'
        ]);
    }

    public function test_restaurant_user_sees_only_their_restaurant_orders(): void
    {
        $restaurantA = Restaurant::factory()->create();
        $restaurantB = Restaurant::factory()->create();

        $restaurantUser = User::factory()->create([
            'role' => UserRoleConstant::RESTAURANT_USER,
            'restaurant_id' => $restaurantA->id,
        ]);

        // Orders for A and B
        Order::factory()->create([
            'user_id' => $restaurantUser->id,
            'restaurant_id' => $restaurantA->id,
            'status' => 'completed',
            'total_amount' => 300,
        ]);

        Order::factory()->create([
            'user_id' => $restaurantUser->id,
            'restaurant_id' => $restaurantB->id,
            'status' => 'completed',
            'total_amount' => 700,
        ]);

        // Expect metrics reflect only restaurantA order when accessed by restaurant user
        $response = $this->actingAs($restaurantUser)->get(route('reports.index'));
        $response->assertOk();
        $response->assertViewIs('dashboard.reports.index');

        // Also check AJAX JSON
        $jsonResponse = $this->actingAs($restaurantUser)->get(route('reports.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $jsonResponse->assertOk();
        $json = $jsonResponse->json();
        $this->assertEquals(1, $json['totalOrders']);
        $this->assertEquals(300, (int) $json['totalRevenue']);
    }
}
