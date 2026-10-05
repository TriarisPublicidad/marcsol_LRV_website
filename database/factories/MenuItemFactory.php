<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition(): array
    {
        return [
            'titulo' => ucfirst($this->faker->word()),
            'url' => '/' . $this->faker->slug(),
            'orden' => $this->faker->numberBetween(1, 10),
            'ubicacion' => 'header',
            'parent_id' => null,
            'status' => true,
        ];
    }
}
