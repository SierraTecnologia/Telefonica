<?php

use Telefonica\Http\Controllers\ProjectController;

Route::group(
    ['middleware' => ['web']], function () {

        Route::prefix('telefonica')->group(
            function () {
                Route::group(
                    ['as' => 'telefonica.'], function () {



                        Route::resource('projects', ProjectController::class);
                        // /**
                        //  * 
                        //  */
                        // Route::get('home', 'HomeController@index')->name('home');
                        // Route::get('persons', 'HomeController@persons')->name('persons');

                        // /**
                        //  * Track
                        //  */
                        // Route::prefix('track')->group(
                        //     function () {
                        //         Route::namespace('Track')->group(
                        //             function () {
                        //                 Route::group(
                        //                     ['as' => 'track.'], function () {

                        //                         Route::get('person', 'PersonController@index')->name('person');

                        //                     }
                        //                 );
                        //             }
                        //         );
                        //     }
                        // );

                    }
                );
            }
        );

    }
);
