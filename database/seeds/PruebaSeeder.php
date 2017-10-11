<?php

use Illuminate\Database\Seeder;
use App\Prueba2;
use Faker\Factory;
class PruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i = 0 ; $i< 1000; $i++){
        	$prueba = new Prueba2([
        		'nombres' => $faker->firstNameMale,
        		'apellidos' => $faker->lastName,
        		'edad' => $faker->biasedNumberBetween($min = 15, $max = 30)
        	]);
        	$prueba->save();
        }
    }
}
