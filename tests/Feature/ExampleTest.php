<?php

it('redirects unauthenticated users from the root to the login page', function () {
    $this->get('/')->assertRedirect('/login');
});
