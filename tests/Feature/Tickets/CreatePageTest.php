<?php

use App\Models\Hero;
use Inertia\Testing\AssertableInertia;

test('create page renders', function () {
    $this->get('/tickets/create')->assertOk();
});

test('create page receives heroes and difficulties props', function () {
    Hero::factory()->count(3)->create();

    $this->get('/tickets/create')
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('tickets/create')
            ->has('heroes', 3)
            ->has('difficulties', 5)
        );
});
