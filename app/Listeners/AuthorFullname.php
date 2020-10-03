<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuthorFullname
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if($event->dataType.name == 'authors'){
            $event->data->Fullname = $event->data->name.' '.$event->data->surname;
            $event->data->save();
        }
    }
}
