<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;
    protected $table = 'models';
    protected $primaryKey = 'id'; // Custom primary key

    protected $fillable = [
        'name',
        'section_id',
        'url',
        'description',
        'permission',
        
    ];

    protected $casts = [
        'permission' => 'array',
    ];

    // Define the relationship with the Section model
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
