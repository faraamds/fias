<?php


namespace faraamds\fias\Classes\Search;


use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class SearchAddressResult
{
    /** @var AddressObject */
    protected $addressObject;

    /** @var House */
    protected $house;

    /** @var Room */
    protected $room;

    /**
     * @param string $aoguid
     * @param string $house
     * @param string|null $building
     * @param string|null $stucture
     * @param string|null $room
     *
     * @return SearchAddressResult
     */
    public function fill(string $aoguid, string $house = null, string $building = null, string $stucture = null, string $room = null) : self
    {
        $this->findAddressObject($aoguid);
        $this->findHouse($house, $building, $stucture);
        $this->findRoom($room);

        return $this;
    }

    /**
     * @return string
     */
    public function toJson() : string
    {
        $address_object = $this->addressObject;
        $house = $this->house;
        $room = $this->room;

        return json_encode(compact('address_object', 'house', 'room'));
    }

    /**
     * @param string $aoguid
     * @param string|null $aoid
     */
    protected function findAddressObject(string $aoguid): void
    {
        /** @var Builder $query */
        $query = AddressObject::where('aoguid', $aoguid)
            ->orderByDesc('enddate');

        $this->addressObject = $query->firstOrFail();
    }

    /**
     * @param string|null $house
     * @param string|null $building
     * @param string|null $stucture
     */
    protected function findHouse(string $house = null, string $building = null, string $stucture = null) : void
    {
        if (!$house) {
            $this->house = null;
            return;
        }
        /** @var Builder $query */
        $query = House::where('aoguid', $this->addressObject->aoguid)
            ->orderByRaw('housenum nulls first')
            ->orderByRaw('buildnum nulls first')
            ->orderByRaw('strucnum nulls first')
            ->orderByDesc('enddate');
        $this->applyPattern($query, 'housenum', $house);

        if ($building) {
            $this->applyPattern($query, 'buildnum', $building);
        }

        if ($stucture) {
            $this->applyPattern($query, 'strucnum', $stucture);
        }

        $this->house = $query->first();
    }

    protected function findRoom(string $room = null) : void
    {
        if ($this->house && $room) {

            /** @var Builder $query */
            $query = Room::where('houseguid', $this->house->houseguid)
                ->orderByRaw('flatnumber nulls first')
                ->orderByRaw('roomnumber nulls first')
                ->orderByDesc('enddate');
            $this->applyPattern($query, 'flatnumber', $room);

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
        $pattern = $this->getPattern($search);

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
