<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\Self_;


class OrderItemFactory extends Factory
{
    public static $UNITS = ['pieces', 'gr', 'kg', 'packages', 'boxes'];
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orders = Order::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();

        return [
            'order_id' => $this->faker->randomElement($orders),
            'product_id' => $this->faker->randomElement($products),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1,10),
            'unit' => self::$UNITS[array_rand(self::$UNITS)],
        ];
    }
}
