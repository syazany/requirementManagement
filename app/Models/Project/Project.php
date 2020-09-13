<?php

namespace App\Models\Project;

use App\Models\Module;
use App\Models\Requirement\Requirement;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'project_status_id', 'uuid'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function requirements()
    {
        return $this->morphMany(Requirement::class, 'requirementable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
//        return $this->belongsToMany(User::class, 'user_id', ProjectUserRole::class);
    }

    public function scopeIndex($query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->withCount(['modules'])->with(['user:id,name']);
    }
}
