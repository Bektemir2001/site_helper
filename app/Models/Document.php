<?php

namespace App\Models;

use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['page_id', 'domain_id', 'header'];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }
}
