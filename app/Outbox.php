<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model {

	protected $table = 'outbox';
    public $timestamps = false;

    public function inbox()
    {
        return $this->belongsToMany('App\Inbox', 'number');
    }


}
