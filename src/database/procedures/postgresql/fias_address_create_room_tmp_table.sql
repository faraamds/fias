CREATE OR REPLACE FUNCTION fias_address_create_room_tmp_table()
    RETURNS VOID AS $BODY$
DECLARE

    var_roomguid UUID;
    var_houseguid UUID;
    var_flatnumber TEXT;
    var_roomnumber TEXT;

BEGIN

    DROP TABLE IF EXISTS fias_room_tmp;
    CREATE TABLE fias_room_tmp
    (roomguid UUID, houseguid UUID, flatnumber TEXT, ao_count SMALLINT);

    FOR var_houseguid, var_roomguid, var_flatnumber, var_roomnumber
        IN SELECT MIN(houseguid::TEXT)::UUID, roomguid,
                  string_agg(DISTINCT flatnumber, ', '),
                  string_agg(DISTINCT roomnumber, ', ')
           FROM fias_room GROUP BY roomguid
    LOOP

        INSERT INTO fias_room_tmp (roomguid, houseguid, flatnumber, ao_count)
        VALUES (var_roomguid, var_houseguid,
                (CASE WHEN var_flatnumber IS NULL THEN '' ELSE ' кв квартира ' || var_flatnumber END ||
                 CASE WHEN var_roomnumber IS NULL THEN '' ELSE ', ком комната ' || var_roomnumber END),
                (200 +
                 (CASE WHEN var_roomnumber IS NULL THEN 0 ELSE 10 END))
                 );

    END LOOP;

    raise notice 'creating houseguid index';
    CREATE INDEX idnx_fias_room_tmp_houseguid ON fias_room_tmp (houseguid);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
