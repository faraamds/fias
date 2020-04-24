<?php


namespace faraamds\fias\Classes\Search;

/**
 * Class Query
 * @package faraamds\fias\Classes\Search
 */
class Query
{
    /** @var bool */
    protected bool $whole_words;

    /** @var string $query */
    protected string $query;

    /** @var array $quoted */
    protected array $quoted;

    /** @var array $pgsql_result */
    protected array $pgsql_result = [];

    /** @var array $sphinx_result */
    protected array $sphinx_result = [];

    /**
     * Query constructor.
     * @param string $query
     */
    public function __construct(string $query, bool $whole_words = false)
    {
        $this->query = $query;
        $this->whole_words = $whole_words;
    }

    /**
     * @param string $query
     * @return string
     */
    public static function toQuery(string $query, bool $whole_words = false) : CompositeQuery
    {
        $query = (new Query($query, $whole_words))
            ->extractAndProcessQuotedStrings()
            ->extractAndProcessOtherStrings();

        return new CompositeQuery($query->getPgsqlQuery(), $query->getSphinxQuery());
    }

    /**
     * @return string
     */
    protected function getPgsqlQuery() : string
    {
        return implode(' & ', $this->filter($this->pgsql_result));
    }

    /**
     * @return string
     */
    protected function getSphinxQuery() : string
    {
        return implode(' ', $this->filter($this->sphinx_result));
    }

    /**
     * @param array $arr
     * @return array
     */
    protected function filter(array $arr): array
    {
        return array_filter($arr, function ($item) {
            return trim((string)$item) !== '';
        });
    }

    /**
     * @return $this
     */
    protected function extractAndProcessQuotedStrings() : self
    {
        return $this->extractQuotedStrings()
            ->processQuotedStrings();
    }

    /**
     * @return $this
     */
    protected function extractAndProcessOtherStrings() : self
    {
        foreach ($this->getOtherStrings() as $otherString) {
            foreach ($this->splitStringToLexemes($otherString) as $lex) {

                $lex = $this->removeQuotes($lex);
                if (empty($lex)) {
                    continue;
                }
                if ($this->hasNoDigit($lex) && !$this->whole_words && !$this->hasSpecial($lex) ) {
                    $pgsql_lex =  $lex . ':*';
                    $sphinx_lex = $lex . '*';
                } else {
                    $pgsql_lex = $lex;
                    $sphinx_lex = '"' . $lex . '"';
                }
                array_push($this->pgsql_result, $pgsql_lex);
                array_push($this->sphinx_result, $sphinx_lex);
            }
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function extractQuotedStrings() : self
    {
        $quoted = [];
        preg_match_all('/[\'\"].+[\'\"]/uU', $this->query, $quoted);
        $this->quoted = $quoted[0];

        return $this;
    }

    /**
     * @return $this
     */
    protected function processQuotedStrings() : self
    {
        foreach ($this->quoted as $lexeme) {
            $lexeme = $this->removeQuotes($lexeme);
            array_push($this->sphinx_result, '"' . trim($lexeme) . '"');
            $lexeme = preg_replace('/\s+/', ' <-> ', trim($lexeme));
            array_push($this->pgsql_result, $lexeme);
        }
        return $this;
    }

    /**
     * @return array
     */
    protected function getOtherStrings() : array
    {
        if (count($this->quoted) > 0) {
            return preg_split('/(' . implode('|', $this->quoted) . ')/', $this->query);
        }
        return [ $this->query ];
    }

    /**
     * @param string $string
     * @return array
     */
    protected function splitStringToLexemes(string $string) : array
    {
        return preg_split('/\s+/', trim($string));
    }

    /**
     * @param string $string
     * @return string
     */
    protected function removeQuotes(string $string) : string
    {
        return trim(preg_replace('/([\'",.])/', '', trim($string)));
    }

    /**
     * @param string $string
     * @return bool
     */
    protected function hasNoDigit(string $string) : bool
    {
        return preg_match('/\D+/', $string);
    }

    /**
     * @param string $string
     * @return bool
     */
    protected function hasSpecial(string $string) : bool
    {
        return preg_match('/[-\/]/', $string);
    }
}
