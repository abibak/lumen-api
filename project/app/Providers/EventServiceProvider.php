<?php

namespace App\Providers;

use App\Events\FinishedMatch;
use App\Events\RecordingUserMatch;
use App\Listeners\RandomWinnerFinishedMatch;
use App\Listeners\SendResponseRecord;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],

        RecordingUserMatch::class => [
          SendResponseRecord::class,
        ],

        FinishedMatch::class => [
          RandomWinnerFinishedMatch::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
