<?php

use Workbench\App\Models\User;

beforeEach(function () {});

test('user can be created', function () {

    User::factory()->create();

    expect(User::count())->toBe(1);
});
