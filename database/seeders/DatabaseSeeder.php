<?php

namespace Database\Seeders;

// use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Burger;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $burgers = [
            [
                'name' => 'Classic Burger',
                'price' => 2500,
                'description' => 'Steak de bœuf grillé, laitue fraîche, tomate, oignon, sauce maison dans un pain brioché toasté.',
                'stock' => 50,
                'available' => true,
            ],
            [
                'name' => 'Double Smash',
                'price' => 3500,
                'description' => 'Double steak smashé, double cheddar fondu, cornichons, moutarde et ketchup artisanal.',
                'stock' => 30,
                'available' => true,
            ],
            [
                'name' => 'Crispy Chicken',
                'price' => 2800,
                'description' => 'Filet de poulet croustillant, coleslaw maison, sauce buffalo, cheddar et jalapeños.',
                'stock' => 40,
                'available' => true,
            ],
            [
                'name' => 'BBQ Ranch',
                'price' => 3200,
                'description' => 'Steak de bœuf, sauce BBQ fumée, bacon croustillant, oignons caramélisés, sauce ranch.',
                'stock' => 25,
                'available' => true,
            ],
            [
                'name' => 'Veggie Burger',
                'price' => 2200,
                'description' => 'Galette de légumes maison, avocat frais, tomate, roquette, sauce yaourt à l\'herbe.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'ISI Special',
                'price' => 4500,
                'description' => 'Notre signature : triple steak, triple cheddar, bacon, œuf au plat, sauce secrète ISI.',
                'stock' => 15,
                'available' => true,
            ],
            [
                'name' => 'Cheese Lover',
                'price' => 3000,
                'description' => 'Steak de bœuf, triple cheddar, fromage fondant, sauce crémeuse.',
                'stock' => 35,
                'available' => true,
            ],
            [
                'name' => 'Spicy Fire',
                'price' => 3100,
                'description' => 'Steak épicé, piment jalapeño, fromage pepper jack et sauce piquante.',
                'stock' => 25,
                'available' => true,
            ],
            [
                'name' => 'Mushroom Melt',
                'price' => 2900,
                'description' => 'Steak de bœuf, champignons sautés, fromage suisse et sauce crémeuse.',
                'stock' => 30,
                'available' => true,
            ],
            [
                'name' => 'Avocado Deluxe',
                'price' => 3300,
                'description' => 'Steak de bœuf, avocat frais, laitue, tomate et sauce citronnée.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Bacon King',
                'price' => 3600,
                'description' => 'Double steak, bacon croustillant, cheddar et sauce BBQ.',
                'stock' => 25,
                'available' => true,
            ],
            [
                'name' => 'Texas Burger',
                'price' => 3400,
                'description' => 'Steak grillé, oignons frits, cheddar et sauce barbecue texane.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Chicken Supreme',
                'price' => 3000,
                'description' => 'Poulet croustillant, laitue, tomate et sauce mayonnaise maison.',
                'stock' => 30,
                'available' => true,
            ],
            [
                'name' => 'Mega Cheese',
                'price' => 3700,
                'description' => 'Double steak, fromage cheddar, mozzarella et sauce fromage.',
                'stock' => 18,
                'available' => true,
            ],
            [
                'name' => 'Green Garden',
                'price' => 2400,
                'description' => 'Burger végétarien avec légumes grillés, avocat et sauce yaourt.',
                'stock' => 22,
                'available' => true,
            ],
            [
                'name' => 'Hot Chicken',
                'price' => 2900,
                'description' => 'Poulet épicé, salade fraîche et sauce piquante.',
                'stock' => 28,
                'available' => true,
            ],
            [
                'name' => 'Golden Burger',
                'price' => 4100,
                'description' => 'Steak premium, cheddar affiné, bacon et sauce spéciale.',
                'stock' => 15,
                'available' => true,
            ],
            [
                'name' => 'Street Burger',
                'price' => 2600,
                'description' => 'Steak grillé, oignons, cornichons et sauce street maison.',
                'stock' => 40,
                'available' => true,
            ],
            [
                'name' => 'Pepper Burger',
                'price' => 3200,
                'description' => 'Steak au poivre, fromage, laitue et sauce poivrée.',
                'stock' => 26,
                'available' => true,
            ],
            [
                'name' => 'Ultimate Burger',
                'price' => 4200,
                'description' => 'Double steak, bacon, cheddar, œuf et sauce secrète.',
                'stock' => 15,
                'available' => true,
            ],
            [
                'name' => 'Mini Smash',
                'price' => 2100,
                'description' => 'Petit smash burger simple et savoureux.',
                'stock' => 45,
                'available' => true,
            ],
            [
                'name' => 'Royal Beef',
                'price' => 3800,
                'description' => 'Steak premium, cheddar, bacon et sauce royale.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Ocean Burger',
                'price' => 3500,
                'description' => 'Burger au poisson croustillant, salade et sauce tartare.',
                'stock' => 25,
                'available' => true,
            ],
            [
                'name' => 'Farm Burger',
                'price' => 3000,
                'description' => 'Steak fermier, fromage, tomate et sauce maison.',
                'stock' => 30,
                'available' => true,
            ],
            [
                'name' => 'Crunch Burger',
                'price' => 3100,
                'description' => 'Steak, oignons frits croustillants et cheddar.',
                'stock' => 22,
                'available' => true,
            ],
            [
                'name' => 'Cheddar Blast',
                'price' => 3300,
                'description' => 'Steak juteux avec cheddar fondu et sauce spéciale.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Urban Burger',
                'price' => 3400,
                'description' => 'Burger street style avec bacon et sauce urbaine.',
                'stock' => 18,
                'available' => true,
            ],
            [
                'name' => 'Fire BBQ',
                'price' => 3600,
                'description' => 'Steak grillé, bacon et sauce BBQ épicée.',
                'stock' => 16,
                'available' => true,
            ],
            [
                'name' => 'Fresh Burger',
                'price' => 2500,
                'description' => 'Burger frais avec salade croquante et tomate.',
                'stock' => 35,
                'available' => true,
            ],
            [
                'name' => 'Monster Burger',
                'price' => 4800,
                'description' => 'Triple steak, triple fromage et bacon croustillant.',
                'stock' => 10,
                'available' => true,
            ],
            [
                'name' => 'Black Pepper Burger',
                'price' => 3300,
                'description' => 'Steak de bœuf au poivre noir, cheddar fondu, laitue et sauce crémeuse.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Honey BBQ Burger',
                'price' => 3400,
                'description' => 'Steak grillé, bacon croustillant, cheddar et sauce BBQ au miel.',
                'stock' => 22,
                'available' => true,
            ],
            [
                'name' => 'Chicken Crunch Deluxe',
                'price' => 3000,
                'description' => 'Filet de poulet croustillant, fromage, laitue et sauce mayo épicée.',
                'stock' => 30,
                'available' => true,
            ],
            [
                'name' => 'Spicy Diablo',
                'price' => 3500,
                'description' => 'Steak épicé, jalapeños, cheddar et sauce diablo ultra piquante.',
                'stock' => 18,
                'available' => true,
            ],
            [
                'name' => 'Italian Burger',
                'price' => 3600,
                'description' => 'Steak de bœuf, mozzarella, tomate, basilic et sauce tomate italienne.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Mega Chicken Burger',
                'price' => 3700,
                'description' => 'Double filet de poulet croustillant, cheddar et sauce maison.',
                'stock' => 15,
                'available' => true,
            ],
            [
                'name' => 'Sweet Chili Burger',
                'price' => 3200,
                'description' => 'Steak de bœuf, salade fraîche et sauce sweet chili.',
                'stock' => 25,
                'available' => true,
            ],
            [
                'name' => 'Tex Mex Burger',
                'price' => 3800,
                'description' => 'Steak grillé, nachos croustillants, cheddar et sauce salsa.',
                'stock' => 17,
                'available' => true,
            ],
            [
                'name' => 'Cheesy Monster',
                'price' => 4200,
                'description' => 'Double steak, triple fromage et sauce cheddar fondante.',
                'stock' => 12,
                'available' => true,
            ],
            [
                'name' => 'Onion Tower Burger',
                'price' => 3100,
                'description' => 'Steak juteux, tour d’oignons frits et sauce barbecue.',
                'stock' => 23,
                'available' => true,
            ],
            [
                'name' => 'California Burger',
                'price' => 3400,
                'description' => 'Steak grillé, avocat, tomate, laitue et sauce fraîche.',
                'stock' => 19,
                'available' => true,
            ],
            [
                'name' => 'Smoked Bacon Burger',
                'price' => 3900,
                'description' => 'Steak premium, bacon fumé, cheddar et sauce smoky.',
                'stock' => 16,
                'available' => true,
            ],
            [
                'name' => 'Double Chicken Melt',
                'price' => 3500,
                'description' => 'Double filet de poulet, fromage fondu et sauce crémeuse.',
                'stock' => 20,
                'available' => true,
            ],
            [
                'name' => 'Ultimate Cheese Burger',
                'price' => 4000,
                'description' => 'Steak épais, mélange de fromages fondus et sauce spéciale.',
                'stock' => 14,
                'available' => true,
            ],
            [
                'name' => 'Street Fire Burger',
                'price' => 3600,
                'description' => 'Steak grillé, piment, cheddar et sauce street épicée.',
                'stock' => 18,
                'available' => true,
            ],
        ];

        foreach ($burgers as $burger) {
            Burger::create($burger);
        }
    }


    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    // $this->call([
    //     BurgerSeeder::class,
    // ]);
    //     // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //     ]);
    // }
}
