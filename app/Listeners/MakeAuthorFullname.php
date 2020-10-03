<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MakeAuthorFullname
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if($event->dataType->name == 'authors'){

            $event->data->fullname = $event->data->name.' '.$event->data->surname;
            $event->data->save();

        }
    }
}
