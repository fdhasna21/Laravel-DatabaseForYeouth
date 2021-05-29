<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class CreatedAtObserver
{
    public function creating(Model $model)
    {
        $model->setCreatedAt($model->freshTimestamp());
    }
}
