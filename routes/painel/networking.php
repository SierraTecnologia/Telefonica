<?php
/**
 * Painel
 */

Route::resource('persons', 'PersonController')->parameters([
    'persons' => 'id'
]);
