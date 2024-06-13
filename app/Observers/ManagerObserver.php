<?php

namespace App\Observers;

use App\Models\Manager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ManagerObserver
{
    /**
     * Handle the Manager "created" event.
     */
    public function created(Manager $manager): void
    {
        //
    }

    /**
     * Handle the Manager "updated" event.
     */
    public function updated(Manager $manager): void
    {
        //
    }

    /**
     * Handle the Manager "deleted" event.
     */
    public function deleted(Manager $manager): void
    {
        $manager->media && $manager->media->each(fn(Media $media)=>$media->delete());
    }

    /**
     * Handle the Manager "restored" event.
     */
    public function restored(Manager $manager): void
    {
        //
    }

    /**
     * Handle the Manager "force deleted" event.
     */
    public function forceDeleted(Manager $manager): void
    {
        //
    }
}
