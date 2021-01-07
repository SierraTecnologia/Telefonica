<?php

Route::resource('/accounts', 'AccountController')->parameters([
    'accounts' => 'id'
]);