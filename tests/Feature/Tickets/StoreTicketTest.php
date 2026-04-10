<?php

use App\Enums\Difficulty;
use App\Models\Hero;
use App\Models\Ticket;

test('successfully creates a ticket via api', function () {
    $response = $this->postJson('/api/tickets', [
        'heroName' => 'Alice',
        'ticketId' => 'JIRA-101',
        'difficulty' => Difficulty::Hard->value,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['ticket_id', 'hero', 'xp']);

    expect(Ticket::where('ticket_id', 'JIRA-101')->exists())->toBeTrue();
});

test('returns validation errors for missing fields', function () {
    $response = $this->postJson('/api/tickets', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['heroName', 'ticketId', 'difficulty']);
});

test('returns validation error for invalid difficulty', function (mixed $difficulty) {
    $response = $this->postJson('/api/tickets', [
        'heroName' => 'Alice',
        'ticketId' => 'JIRA-101',
        'difficulty' => $difficulty,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['difficulty']);
})->with([0, 6, 'abc', -1]);

test('returns correct json structure', function () {
    $response = $this->postJson('/api/tickets', [
        'heroName' => 'Alice',
        'ticketId' => 'JIRA-101',
        'difficulty' => 3,
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'ticket_id' => 'JIRA-101',
            'hero' => 'Alice',
            'xp' => 30,
        ]);
});

test('web form creates ticket and redirects to board', function () {
    $hero = Hero::factory()->create();

    $response = $this->post('/tickets', [
        'title' => 'Fix bug',
        'ticketId' => 'JIRA-201',
        'difficulty' => Difficulty::Easy->value,
        'heroId' => $hero->id,
    ]);

    $response->assertRedirect(route('board.index'));
    expect(Ticket::where('ticket_id', 'JIRA-201')->exists())->toBeTrue();
});

test('web form returns validation errors', function () {
    $response = $this->post('/tickets', []);

    $response->assertSessionHasErrors(['title', 'ticketId', 'difficulty', 'heroId']);
});

test('web form rejects duplicate ticket id', function () {
    $hero = Hero::factory()->create();
    Ticket::factory()->create(['ticket_id' => 'JIRA-201']);

    $response = $this->post('/tickets', [
        'title' => 'Fix bug',
        'ticketId' => 'JIRA-201',
        'difficulty' => Difficulty::Easy->value,
        'heroId' => $hero->id,
    ]);

    $response->assertSessionHasErrors(['ticketId']);
});
