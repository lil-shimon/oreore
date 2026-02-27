<?php

test('guests are redirected to login from root', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
