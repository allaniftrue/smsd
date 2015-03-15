<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class inbox extends Model {

    protected $table = 'inbox';
    public $timestamps = false;

    public function outbox()
    {
        return $this->belongsToMany('App\Outbox', 'number');
    }

}
