<?php


namespace faraamds\fias\Classes\Search;

/**
 * Class Query
 * @package faraamds\fias\Classes\Search
 */
class Query
{
    /** @var string $query */
    protected string $query;

    /** @var array $quoted */
    protected array $quoted;

    /** @var array $result */
    protected array $result = [];

    /**
     * Query constructor.
     * @param string $query
     */
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    /**
     * @param string $query
     * @return string
     */
    public static function toTsQuery(string $query)
    {
        $query = (new Query($query))
            ->extractAndProcessQuotedStrings()
            ->extractAndProcessOtherStrings()
            ->toString();

        return $query;
    }

    /**
     * @return string
     */
    protected function toString()
    {
        return implode(' & ', $this->filter($this->result));
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
                if ($this->hasNoDigit($lex)) {
                    $lex .= ':*';
                }
                array_push($this->result, $lex);
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
            $lexeme = preg_replace('/\s+/', ' <-> ', trim($lexeme));
            array_push($this->result, $lexeme);
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
        return preg_replace('/([\'"])/', '', trim($string));
    }

    /**
     * @param string $string
     * @return bool
     */
    protected function hasNoDigit(string $string) : bool
    {
        return preg_match('/\D+/', $string);
    }
}
