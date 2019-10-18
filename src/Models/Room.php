<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    protected $table = 'fias_room';

    protected $fillable = ['roomguid', 'flatnumber', 'flattype', 'roomnumber', 'roomtype', 'regioncode',
        'postalcode', 'updatedate', 'houseguid', 'roomid', 'previd', 'nextid', 'startdate', 'enddate',
        'livestatus', 'normdoc', 'operstatus', 'cadnum', 'roomcadnum', ];

    protected $visible = ['id', 'roomguid', 'flatnumber', 'flattype', 'roomnumber', 'roomtype', 'regioncode',
        'postalcode', 'updatedate', 'houseguid', 'roomid', 'previd', 'nextid', 'startdate', 'enddate',
        'livestatus', 'normdoc', 'operstatus', 'cadnum', 'roomcadnum',];

    protected $cast = [
        'id'         => 'integer',   //
        'roomguid'   => 'string',    // Глобальный уникальный идентификатор адресного объекта (помещения)
        'flatnumber' => 'string',    // Номер помещения или офиса
        'flattype'   => 'integer',   // Тип помещения
        'roomnumber' => 'string',    // Номер комнаты
        'roomtype'   => 'integer',   // Тип комнаты
        'regioncode' => 'string',    // Код региона
        'postalcode' => 'string',    // Почтовый индекс
        'updatedate' => 'date',      // Дата  внесения записи
        'houseguid'  => 'string',    // Идентификатор родительского объекта (дома)
        'roomid'     => 'string',    // Уникальный идентификатор записи. Ключевое поле.
        'previd'     => 'string',    // Идентификатор записи связывания с предыдушей исторической записью
        'nextid'     => 'string',    // Идентификатор записи  связывания с последующей исторической записью
        'startdate'  => 'date',      // Начало действия записи
        'enddate'    => 'date',      // Окончание действия записи
        'livestatus' => 'integer',   // Признак действующего адресного объекта
        'normdoc'    => 'string',    // Внешний ключ на нормативный документ
        'operstatus' => 'integer',   // Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):
                                     //     01 – Инициация;
                                     //     10 – Добавление;
                                     //     20 – Изменение;
                                     //     21 – Групповое изменение;
                                     //     30 – Удаление;
                                     //     31 - Удаление вследствие удаления вышестоящего объекта;
                                     //     40 – Присоединение адресного объекта (слияние);
                                     //     41 – Переподчинение вследствие слияния вышестоящего объекта;
                                     //     42 - Прекращение существования вследствие присоединения к другому адресному объекту;
                                     //     43 - Создание нового адресного объекта в результате слияния адресных объектов;
                                     //     50 – Переподчинение;
                                     //     51 – Переподчинение вследствие переподчинения вышестоящего объекта;
                                     //     60 – Прекращение существования вследствие дробления;
                                     //     61 – Создание нового адресного объекта в результате дробления

        'cadnum'     => 'string',    // Кадастровый номер помещения
        'roomcadnum' => 'string',    // Кадастровый номер комнаты в помещении
    ];

    /**
     * @return BelongsTo
     */
    public function house() : BelongsTo
    {
        return $this->belongsTo(House::class, 'houseguid', 'houseguid')->where('is_last', true);
    }

}