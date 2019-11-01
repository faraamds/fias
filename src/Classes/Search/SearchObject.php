<?php


namespace faraamds\fias\Classes\Search;


use Illuminate\Support\Arr;

class SearchObject
{
    /** @var string */
    public $postal_code;

    /** @var string */
    public $house;

    /** @var string */
    public $apartment;

    /** @var array */
    protected $keywords;

    /**
     * SearchObject constructor.
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->splitToKeywords($address);
        $this->processKeywords();
    }

    /**
     * @return string
     */
    public function getKeywords() : string
    {
        return implode(' | ', $this->keywords);
    }

    protected function splitToKeywords(string $address) : void
    {
//        $this->keywords = explode(',', $address);
        $this->keywords = preg_split("/[\s,]+/", $address);
    }

    protected function processKeywords() : void
    {
        $this->extractPostalCode();
//        $this->extract();
    }

    protected function extractPostalCode() : void
    {
        $first = Arr::first($this->keywords);

        if (ctype_digit($first)) {
            $this->postal_code = $first;
            $this->keywords = array_slice($this->keywords, 1);
        }
    }

    protected function extract() : void
    {
        $pure_keywords = [];
        foreach ($this->keywords as $keyword) {

            if (! $this->checkAndExtractHouseOrApartment($keyword)) {

                array_push($pure_keywords, trim($keyword));
            }
        }

        $this->keywords = $pure_keywords;
    }

    /**
     * @param string $keyword
     * @return bool
     */
    protected function checkAndExtractHouseOrApartment(string $keyword) : bool
    {
        if (preg_match('/^\s*(дом|д)[\s.]/i', $keyword)) {
            $this->house = trim(Arr::first(preg_split('/^[\s]*(дом|д)[\s.]/i', $keyword, 0, PREG_SPLIT_NO_EMPTY)));
            return true;
        }

        if (preg_match('/^\s*(квартира|кв|к)[\s.]/i', $keyword)) {
            $this->apartment = trim(Arr::first(preg_split('/^[\s]*(квартира|кв|к)[\s.]/i', $keyword, 0, PREG_SPLIT_NO_EMPTY)));
            return true;
        }

        if (preg_match('/^\s*\d+\/\d+\s*$/i', $keyword)) {
            $this->extractHouseOrApartment($keyword);
            return true;
        }

        if (preg_match('/^\s*\d+[\s-]?[\s-]?[\w]\s*$/i', $keyword)) {
            $this->extractHouseOrApartment($keyword);
            return true;
        }

        return false;
    }

    /**
     * @param string $keyword
     */
    protected function extractHouseOrApartment(string $keyword) : void
    {
        if (!$this->house) {
            $this->house = trim($keyword);
            return;
        } elseif (!$this->apartment) {
            $this->apartment = trim($keyword);
            return;
        } else {
            return;
        }
    }
}