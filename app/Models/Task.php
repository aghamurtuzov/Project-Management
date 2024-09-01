<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'description', 'status'];

    public function Project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function scopeName($query, $name)
    {
        if ($name != null) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        } else {
            return $query;
        }
    }

    public function scopeStatus($query, $status)
    {
        if ($status != null) {
            return $query->where('status', 'LIKE', '%' . $status . '%');
        } else {
            return $query;
        }
    }

    public function scopeProjectId($query, $projectId)
    {
        if ($projectId != null) {
            return $query->where('project_id', $projectId);
        } else {
            return $query;
        }
    }
}
