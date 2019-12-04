<?php


namespace faraamds\fias\Classes\Search;


use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class SearchHouseRoomResult
{
    /** @var House */
    protected ?House $house;

    /** @var Room */
    protected ?Room $room;

    /**
     * SearchAddressResult constructor.
     */
    public function __construct()
    {
        $this->house = null;
        $this->room = null;
    }

    /**
     * @param string $aoguid
     * @param string $house
     * @param string|null $building
     * @param string|null $structure
     * @param string|null $room
     * @return SearchHouseRoomResult
     */
    public function find(string $aoguid, string $house, string $building = null, string $structure = null, string $room = null) : self
    {
        $this->findHouse($aoguid, $house, $building, $structure);
        $this->findRoom($room);

        return $this;
    }

    /**
     * @return string
     */
    public function toJson() : string
    {
        $house = $this->house;
        $room = $this->room;

        return json_encode(compact('house', 'room'));
    }

    /**
     * @param string $aoguid
     * @param string|null $house
     * @param string|null $building
     * @param string|null $structure
     */
    protected function findHouse(string $aoguid, string $house, string $building = null, string $structure = null) : void
    {
        /** @var Builder $query */
        $query = House::where('aoguid', $aoguid)
            ->orderByRaw('housenum')
            ->orderByRaw('buildnum nulls first')
            ->orderByRaw('strucnum nulls first')
            ->orderByDesc('enddate');
        $this->applyPattern($query, 'housenum', $house);

        if ($building) {
            $this->applyPattern($query, 'buildnum', $building);
        }

        if ($structure) {
            $this->applyPattern($query, 'strucnum', $structure);
        }

        $this->house = $query->first();
    }

    /**
     * @param string $room
     */
    protected function findRoom(string $room = null) : void
    {
        if ($this->house && $room) {

            /** @var Builder $query */
            $query = Room::where('houseguid', $this->house->houseguid)
                ->orderByRaw('flatnumber')
                ->orderByRaw('roomnumber nulls first')
                ->orderByDesc('enddate');
            self::applyPattern($query, 'flatnumber', $room);

            $this->room = $query->first();
        }
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $search
     * @return Builder
     */
    protected function applyPattern(Builder $query, string $column, string $search) : Builder
    {
        $pattern = self::getPattern($search);

        return $query->whereRaw("{$column} ~* '{$pattern}'");
    }

    /**
     * @param string $str
     * @return string
     */
    protected function getPattern(string $str) : string
    {
        $keys = preg_split('/([\d]+)([\D]+)/i', $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $keys = array_map(function ($item) {
            return trim($item);
        }, $keys);
        $keys = array_filter($keys, function ($item) {
            return !preg_match('/[\/-]/', preg_replace('/\s/', '', $item));
        });

        return '^' . implode('[-/\s]*', $keys);
    }
}
