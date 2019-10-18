<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AddressObject extends Model
{
    protected $table = 'fias_address_object';

    protected $fillable = ['real_depth', 'position', 'aoguid', 'formalname', 'regioncode', 'autocode',
        'areacode', 'citycode', 'ctarcode', 'placecode', 'plancode', 'streetcode', 'extrcode', 'sextcode',
        'offname', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate',
        'shortname', 'aolevel', 'parentguid', 'aoid', 'previd', 'nextid', 'code', 'plaincode', 'actstatus',
        'centstatus', 'operstatus', 'currstatus', 'startdate', 'enddate', 'normdoc', 'livestatus', 'divtype'];

    protected $visible = ['id', 'real_depth', 'position', 'aoguid', 'formalname', 'regioncode', 'autocode',
        'areacode', 'citycode', 'ctarcode', 'placecode', 'plancode', 'streetcode', 'extrcode', 'sextcode',
        'offname', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate',
        'shortname', 'aolevel', 'parentguid', 'aoid', 'previd', 'nextid', 'code', 'plaincode', 'actstatus',
        'centstatus', 'operstatus', 'currstatus', 'startdate', 'enddate', 'normdoc', 'livestatus', 'divtype'];

    protected $cast = [
        'id'         => 'integer',  //
        'position'   => 'integer',  //
        'aoguid'     => 'string',   // Глобальный уникальный идентификатор адресного объекта
        'formalname' => 'string',   // Формализованное наименование
        'regioncode' => 'string',   // Код региона
        'autocode'   => 'string',   // Код автономии
        'areacode'   => 'string',   // Код района
        'citycode'   => 'string',   // Код города
        'ctarcode'   => 'string',   // Код внутригородского района
        'placecode'  => 'string',   // Код населенного пункта
        'plancode'   => 'string',   // Код элемента планировочной структуры
        'streetcode' => 'string',   // Код улицы
        'extrcode'   => 'string',   // Код дополнительного адресообразующего элемента
        'sextcode'   => 'string',   // Код подчиненного дополнительного адресообразующего элемента
        'offname'    => 'string',   // Официальное наименование
        'postalcode' => 'string',   // Почтовый индекс
        'ifnsfl'     => 'string',   // Код ИФНС ФЛ
        'terrifnsfl' => 'string',   // Код территориального участка ИФНС ФЛ
        'ifnsul'     => 'string',   // Код ИФНС ЮЛ
        'terrifnsul' => 'string',   // Код территориального участка ИФНС ЮЛ
        'okato'      => 'string',   // ОКАТО
        'oktmo'      => 'string',   // ОКТМО
        'updatedate' => 'date',     // Дата  внесения (обновления) записи
        'shortname'  => 'string',   // Краткое наименование типа объекта
        'aolevel'    => 'integer',  // Уровень адресного объекта
                                    //        1 – уровень региона
                                    //        2 – уровень автономного округа (устаревшее)
                                    //        3 – уровень района
                                    //        35 – уровень городских и сельских поселений
                                    //        4 – уровень города
                                    //        5 – уровень внутригородской территории (устаревшее)
                                    //        6 – уровень населенного пункта
                                    //        65 – планировочная структура
                                    //        7 – уровень улицы
                                    //        75 – земельный участок
                                    //        8 – здания, сооружения, объекта незавершенного строительства
                                    //        9 – уровень помещения в пределах здания, сооружения
                                    //        90 – уровень дополнительных территорий (устаревшее)
                                    //        91 – уровень объектов на дополнительных территориях (устаревшее)
        'parentguid' => 'string',   // Идентификатор объекта родительского объекта
        'aoid'       => 'string',   // Уникальный идентификатор записи. Ключевое поле.
        'previd'     => 'string',   // Идентификатор записи связывания с предыдушей исторической записью
        'nextid'     => 'string',   // Идентификатор записи  связывания с последующей исторической записью
        'code'       => 'string',   // Код адресного элемента одной строкой с признаком актуальности из классификационного кода
        'plaincode'  => 'string',   // Код адресного элемента одной строкой без признака актуальности (последних двух цифр)
        'actstatus'  => 'integer',  // Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте.
                                    //    0 – Не последняя
                                    //    1 - Последняя
        'centstatus' => 'integer',  // Статус центра
                                    //        0 – объект не является центром административно-территориального образования;
                                    //        1 – объект является центром района;
                                    //        2 – объект является центром (столицей) региона;
                                    //        3 – объект является одновременно и центром района и центром региона.
        'operstatus' => 'integer',  // Статус действия над записью – причина появления записи (см. OperationStatuses )
                                    //        01 – Инициация;
                                    //        10 – Добавление;
                                    //        20 – Изменение;
                                    //        21 – Групповое изменение;
                                    //        30 – Удаление;
                                    //        31 - Удаление вследствие удаления вышестоящего объекта;
                                    //        40 – Присоединение адресного объекта (слияние);
                                    //        41 – Переподчинение вследствие слияния вышестоящего объекта;
                                    //        42 - Прекращение существования вследствие присоединения к другому адресному объекту;
                                    //        43 - Создание нового адресного объекта в результате слияния адресных объектов;
                                    //        50 – Переподчинение;
                                    //        51 – Переподчинение вследствие переподчинения вышестоящего объекта;
                                    //        60 – Прекращение существования вследствие дробления;
                                    //        61 – Создание нового адресного объекта в результате дробления
        'currstatus' => 'integer',  // Статус актуальности КЛАДР 4 (последние две цифры в коде)
        'startdate'  => 'date',     // Начало действия записи
        'enddate'    => 'date',     // Окончание действия записи
        'normdoc'    => 'string',   // Внешний ключ на нормативный документ
        'livestatus' => 'integer',  // Признак действующего адресного объекта
        'divtype'    => 'integer',  // Тип адресации
                                    //        0 - не определено
                                    //        1 - муниципальный;
                                    //        2 - административно-территориальный

    ];

    /**
     * @return string
     */
    public function getActualAddressString()
    {
        return Arr::first(DB::select('SELECT * FROM fias_address_formal(?) as addr', [$this->aoguid]), null,
            [(object)[ 'addr' => null ]]
        )->addr;
    }

    /**
     * @return BelongsTo
     */
    public function next() : BelongsTo
    {
        return $this->belongsTo(AddressObject::class, 'nextid', 'aoid');
    }

    /**
     * @return BelongsTo
     */
    public function previous() : BelongsTo
    {
        return $this->belongsTo(AddressObject::class, 'previd', 'aoid');
    }

    /**
     * @return HasMany
     */
    public function houses() : HasMany
    {
        return $this->hasMany(House::class, 'aoguid', 'aoguid')
            ->where('is_last', true);
    }
}