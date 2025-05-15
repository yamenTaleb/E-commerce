<?php

if (! function_exists('pagination_links')) {
    function pagination_links($records): array
    {
       return [
           'total' => $records->total(),
           'current_page' => $records->currentPage(),
           'per_page' => $records->perPage(),
           'last_page' => $records->lastPage(),
           'next_page_url' => $records->nextPageUrl(),
           'prev_page_url' => $records->previousPageUrl(),
       ];
    }
}
