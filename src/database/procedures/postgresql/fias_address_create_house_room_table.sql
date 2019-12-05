CREATE OR REPLACE FUNCTION fias_address_create_house_room_table()
    RETURNS VOID AS $BODY$
DECLARE

BEGIN

    CREATE TABLE fias_house_room_tmp (aoguid UUID, houseguid UUID, roomguid UUID, house VARCHAR(255), buildnum VARCHAR(255), flatnumber VARCHAR(255));

    INSERT INTO fias_house_room_tmp SELECT DISTINCT fias_house.aoguid, fias_house.houseguid, fias_room.roomguid,
            CASE WHEN fias_house.housenum IS NULL THEN '' ELSE 'д дом ' || fias_house.housenum END,
            (CASE WHEN fias_house.buildnum IS NULL THEN '' ELSE ', к корп корпус ' || fias_house.buildnum END ||
            CASE WHEN fias_house.strucnum IS NULL THEN '' ELSE ', стр строение ' || fias_house.strucnum END),
            (CASE WHEN fias_room.flatnumber IS NULL THEN '' ELSE ', кв квартира ' || fias_room.flatnumber END ||
            CASE WHEN fias_room.roomnumber IS NULL THEN '' ELSE ', ком комната ' || fias_room.roomnumber END)
    FROM fias_house LEFT JOIN fias_room ON fias_room.houseguid=fias_house.houseguid;

    CREATE INDEX idnx_fias_house_room_tmp_aoguid ON fias_house_room_tmp (aoguid);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
