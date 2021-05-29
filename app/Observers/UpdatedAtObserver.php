<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class UpdatedAtObserver
{
    public function updating(Model $model){
        $model->setUpdatedAt($model->freshTimestamp());
    }
}
