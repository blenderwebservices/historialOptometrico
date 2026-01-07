<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['frame', 'accessory', 'lenses', 'cleaning'];
        $type = $this->faker->randomElement($types);

        $products = [
            'frame' => ['Ray-Ban Classic', 'Oakley Sport', 'Gucci Fashion', 'Prada Elegant', 'Vogue Chic', 'Armani Exchange', 'Tom Ford Luxury'],
            'accessory' => ['Lens Case', 'Microfiber Cloth', 'Screwdriver Kit', 'Anti-fog Spray', 'Eyeglass Chain'],
            'lenses' => ['Blue Light Blocking', 'Transitions Gen 8', 'Polarized Sun', 'Progressive HD', 'Single Vision Poly'],
            'cleaning' => ['Ultra-Pure Spray', 'Cleaning Foam', 'Wipes 50pk'],
        ];

        $name = $this->faker->randomElement($products[$type]);
        $brand = $this->faker->randomElement(['Ray-Ban', 'Oakley', 'Essilor', 'Zeiss', 'Hoya', 'Luxottica']);

        return [
            'name' => $name . ' ' . $this->faker->word(),
            'type' => $type,
            'brand' => $brand,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'stock' => $this->faker->numberBetween(0, 50),
        ];
    }
}
