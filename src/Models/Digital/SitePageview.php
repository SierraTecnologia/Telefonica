<?php

declare(strict_types=1);

namespace Telefonica\Models\Digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SitePageview extends Model
{
    protected $table = 'site_pageviews';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['views' => 'integer'];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
