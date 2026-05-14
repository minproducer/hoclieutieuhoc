<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Document extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'drive_file_id',
        'drive_view_link',
        'file_type',
        'file_size_kb',
        'page_count',
        'category_id',
        'uploader_id',
        'status',
        'is_public',
        'is_featured',
        'view_count',
        'download_count',
        'grade_level',
        'thumbnail_url',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'file_size_kb' => 'integer',
        'page_count' => 'integer',
        'grade_level' => 'integer',
        'category_id' => 'integer',
        'uploader_id' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(DownloadLog::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getPreviewUrlAttribute(): string
    {
        if ($this->drive_file_id) {
            return "https://drive.google.com/file/d/{$this->drive_file_id}/preview";
        }
        return '';
    }

    public function getDownloadUrlAttribute(): string
    {
        if ($this->drive_file_id) {
            return "https://drive.google.com/uc?export=download&id={$this->drive_file_id}";
        }
        return '';
    }

    public function getThumbnailDisplayUrlAttribute(): ?string
    {
        $thumbnail = $this->attributes['thumbnail_url'] ?? null;

        if (is_string($thumbnail) && $thumbnail !== '') {
            if (str_starts_with($thumbnail, 'http://') || str_starts_with($thumbnail, 'https://')) {
                return $thumbnail;
            }

            return Storage::disk('public')->url($thumbnail);
        }

        if ($this->drive_file_id) {
            return "https://drive.google.com/thumbnail?id={$this->drive_file_id}&sz=w1200";
        }

        return null;
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (! $this->file_size_kb) {
            return 'N/A';
        }
        if ($this->file_size_kb >= 1024) {
            return round($this->file_size_kb / 1024, 1) . ' MB';
        }
        return $this->file_size_kb . ' KB';
    }

    public function getGradeLabelAttribute(): ?string
    {
        if ($this->grade_level === null) {
            return null;
        }
        if ($this->grade_level == 0) {
            return 'Tiền Tiểu học';
        }
        return 'Lớp ' . $this->grade_level;
    }

    public function getGradeLevelGroupAttribute(): ?string
    {
        if ($this->grade_level === null) {
            return null;
        }
        if ($this->grade_level == 0) {
            return 'Tiền Tiểu học';
        }
        if ($this->grade_level <= 5) {
            return 'Tiểu học';
        }
        return null; // grades outside scope
    }

    public static function fileTypeColors(): array
    {
        return [
            'pdf'   => 'danger',
            'docx'  => 'info',
            'pptx'  => 'warning',
            'xlsx'  => 'success',
            'zip'   => 'purple',
            'image' => 'pink',
        ];
    }
}
