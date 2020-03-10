<?php


namespace faraamds\fias\Classes\Search;


class CompositeQuery
{
    /** @var string <p>Запрос для постоения нужной цепочки адреса</p> */
    public string $pgsql_check_query;

    /** @var string <p>Запрос для поиска адресного объекта</p> */
    public string $sphinx_search_query;

    /**
     * CompositeQuery constructor.
     * @param string $pgsql_check_query
     * @param string $sphinx_search_query
     */
    public function __construct(string $pgsql_check_query, string $sphinx_search_query)
    {
        $this->pgsql_check_query = $pgsql_check_query;
        $this->sphinx_search_query = $sphinx_search_query;
    }
}
