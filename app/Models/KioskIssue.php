<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class KioskIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'pdf',
        'cover',
        'isActive',
        'author_id',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function pdfUrl(): string
    {
        return Storage::url($this->pdf);
    }

    public function coverUrl(): ?string
    {
        return $this->cover ? Storage::url($this->cover) : null;
    }
}