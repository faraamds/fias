<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    protected $table = 'fias_house';

    protected $fillable = [
        'postalcode', 'regioncode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate',
        'housenum', 'eststatus', 'buildnum', 'strucnum', 'strstatus', 'houseid', 'houseguid', 'aoguid', 'startdate',
        'enddate', 'statstatus', 'normdoc', 'counter', 'cadnum', 'divtype', 'is_last',
    ];

    protected $visible = [
        'id', 'postalcode', 'regioncode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate',
        'housenum', 'eststatus', 'buildnum', 'strucnum', 'strstatus', 'houseid', 'houseguid', 'aoguid', 'startdate',
        'enddate', 'statstatus', 'normdoc', 'counter', 'cadnum', 'divtype', 'is_last',
        ];

    protected $cast = [
        'id'         => 'integer',  //
        'postalcode' => 'string',   // Почтовый индекс
        'regioncode' => 'string',   // Код региона
        'ifnsfl'     => 'string',   // Код ИФНС ФЛ
        'terrifnsfl' => 'string',   // Код территориального участка ИФНС ФЛ
        'ifnsul'     => 'string',   // Код ИФНС ЮЛ
        'terrifnsul' => 'string',   // Код территориального участка ИФНС ЮЛ
        'okato'      => 'string',   // OKATO
        'oktmo'      => 'string',   // OKTMO
        'updatedate' => 'date',     // Дата время внесения записи
        'housenum'   => 'string',   // Номер дома
        'eststatus'  => 'integer',  // Признак владения
        'buildnum'   => 'string',   // Номер корпуса
        'strucnum'   => 'string',   // Номер строения
        'strstatus'  => 'integer',  // Признак строения
        'houseid'    => 'string',   // Уникальный идентификатор записи дома
        'houseguid'  => 'string',   // Глобальный уникальный идентификатор дома
        'aoguid'     => 'string',   // Guid записи родительского объекта (улицы, города, населенного пункта и т.п.)
        'startdate'  => 'date',     // Начало действия записи
        'enddate'    => 'date',     // Окончание действия записи
        'statstatus' => 'integer',  // Состояние дома
        'normdoc'    => 'string',   // Внешний ключ на нормативный документ
        'counter'    => 'integer',  // Счетчик записей домов для КЛАДР 4
        'cadnum'     => 'string',   // Кадастровый номер
        'divtype'    => 'integer',  // Тип адресации:
                                    //    0 - не определено
                                    //    1 - муниципальный;
                                    //    2 - административно-территориальный
        'is_last'    => 'boolean',  // Признак последней записи
    ];

    /**
     * @return HasMany
     */
    public function rooms() : HasMany
    {
        return $this->hasMany(Room::class, 'houseguid', 'houseguid')
            ->whereNull('nextid');
    }

    /**
     * @return BelongsTo
     */
    public function addressObject() : BelongsTo
    {
        return $this->belongsTo(AddressObject::class, 'aoguid', 'aoguid')->latest('enddate');
    }
}