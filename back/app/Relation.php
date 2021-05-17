<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
      /**
       * The table associated with the model.
       * 
       * @var string
       */
      protected $table = 'relations';

      /**
       * The "type" of the auto-incrementing ID.
       * 
       * @var string
       */
      protected $keyType = 'integer';

      /**
       * @var array
       */
      protected $fillable = ['node_id', 'related_node_id'];

      protected $hidden = ['pivot'];

      public function nodes()
      {
          return $this->belongsTo('App\Node','id');
      }
}
