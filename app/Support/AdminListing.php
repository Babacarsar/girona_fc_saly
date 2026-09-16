<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminListing
{
    public static function applySort(Builder $query, Request $request, array $allowed, string $default = 'created_at', string $defaultDir = 'desc'): Builder
    {
        $sort = $request->get('sort', $default);
        if (! in_array($sort, $allowed, true)) {
            $sort = $default;
        }

        $dir = strtolower((string) $request->get('dir', $defaultDir)) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sort, $dir);
    }
}
