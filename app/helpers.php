<?php

if (!function_exists('when')) {
    function when(bool $condition, callable $true, ?callable $false = null)
    {
        if ($condition) {
            return $true();
        }
        if ($false) {
            return $false();
        }

        return null;
    }
}

if (!function_exists('meta')) {
    function meta(\Illuminate\Pagination\LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'next_page_url' => $paginator->nextPageUrl(),
            'links' => $paginator->linkCollection(),
        ];
    }
}
