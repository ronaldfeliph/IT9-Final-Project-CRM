<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{   
    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'source',
        'status',
        'priority',
        'expected_value',
        'notes',
        'assigned_user_id'
    ];

    protected function casts(): array
    {
        return [
            'expected_value' => 'decimal:2',
        ];
    }

    const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'qualified' => 'Qualified',
        'proposal_sent' => 'Proposal Sent',
        'negotiation' => 'Negotiation',
        'won' => 'Won',
        'lost' => 'Lost',
    ];

    const PRIORITIES = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ];

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['won', 'lost']);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
 
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
 
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }
}
