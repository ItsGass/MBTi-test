<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('the home page renders the type grid and compatibility spotlight', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Empat dimensi')
        ->assertSee('INTJ')
        ->assertSee('Sorotan kecocokan');
});

test('the type index lists all sixteen types', function () {
    $response = $this->get(route('types.index'))->assertOk();

    foreach (['INTJ', 'ENFP', 'ISFJ', 'ESTP'] as $code) {
        $response->assertSee($code);
    }
});

test('a type profile shows strengths weaknesses and compatibility ranking', function () {
    $this->get(route('types.show', 'INFJ'))
        ->assertOk()
        ->assertSee('INFJ')
        ->assertSee('Kekuatan utama')
        ->assertSee('Titik yang perlu dijaga')
        ->assertSee('Rekomendasi karier');
});

test('the compatibility index renders the picker', function () {
    $this->get(route('compatibility.index'))
        ->assertOk()
        ->assertSee('Tipe pertama')
        ->assertSee('Tipe kedua');
});
