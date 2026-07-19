<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardSubjectTest extends TestCase
{
    public function test_dashboard_shows_subject_summary(): void
    {
        $response = $this->get('/dashboard-admin');

        $response->assertStatus(200)
            ->assertSee('Total Subjects')
            ->assertSee('Recent Subjects');
    }
}
