<?php
/**
 * Admin
 */

Route::resource('phones', 'PhoneController')->parameters([
    'phones' => 'id'
]);