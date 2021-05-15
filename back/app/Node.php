<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'nodes';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['graph_id', 'tooltip'];

    protected $hidden = ['pivot','graph_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function graph()
    {
        return $this->belongsTo('App\Graph');
    }

    public function relations()
    {
        return $this->belongsToMany('App\Node','App\Relation','node_id','related_node_id');
    }
}
