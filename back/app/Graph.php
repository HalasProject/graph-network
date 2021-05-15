<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
     /**
     * The table associated with the model.
     * 
     * @var string
     */
     protected $table = 'graphs';

     /**
      * The "type" of the auto-incrementing ID.
      * 
      * @var string
      */
     protected $keyType = 'integer';
 
     /**
      * @var array
      */
     protected $fillable = ['name', 'description'];

 
     /**
      * @return \Illuminate\Database\Eloquent\Relations\hasMany
      */
     public function nodes()
     {
         return $this->hasMany('App\Node');
     }
}
