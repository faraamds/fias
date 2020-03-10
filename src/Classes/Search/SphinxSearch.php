<?php


namespace faraamds\fias\Classes\Search;

use Illuminate\Support\Facades\DB;

class SphinxSearch
{
    public static function search(CompositeQuery $query, int $limit = 10) : array
    {
        $indexes = DB::connection('sphinx')
            ->table('fias_index')
            ->whereRaw("MATCH('{$query->sphinx_search_query}')")
            ->orderByRaw('ao_count asc')
            ->orderByRaw('WEIGHT() desc')
            ->limit($limit)
            ->get();

        return DB::select(
            'SELECT * from fias_get_search_by_ids(ARRAY['. $indexes->pluck('id')->implode(',') . ']::BIGINT[], ?)',
             [$query->pgsql_check_query]
            );
    }
}
