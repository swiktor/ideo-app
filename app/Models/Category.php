<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Uuids;

    protected $fillable = [
        'name',
        'parent_id',
        'order',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function move($lastOrder)
    {
        $lastOrderOrder = $lastOrder->order;

        $lastOrder->update([
            'order'=>$this->order
        ]);
        $this->update([
            'order' => $lastOrderOrder
        ]);
    }

    public function sort()
    {
        $branch = Category::where('parent_id', '=', $this->parent_id)->get();
        $branch->sortBy('order');

        for ($x = 0; $x < count($branch); $x++)
        {
            $branch[$x]->update([
                'order' => $x,
            ]);
        }
    }
}
