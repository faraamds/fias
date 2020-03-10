CREATE OR REPLACE FUNCTION fias_address_create_house_room_table()
    RETURNS VOID AS $BODY$
DECLARE

BEGIN
    DROP TABLE IF EXISTS fias_house_room_tmp;
    CREATE TABLE fias_house_room_tmp (aoguid UUID, houseguid UUID, roomguid UUID, house TEXT, buildnum TEXT,
    flatnumber TEXT, ao_count INT);

    INSERT INTO fias_house_room_tmp
        SELECT aoguid, houseguid, null, house, buildnum, null, ao_count
        FROM fias_house_tmp;

    INSERT INTO fias_house_room_tmp
        SELECT ht.aoguid, rt.houseguid, rt.roomguid, ht.house, ht.buildnum, rt.flatnumber,
               ht.ao_count + rt.ao_count
        FROM fias_room_tmp rt JOIN fias_house_tmp ht ON rt.houseguid = ht.houseguid;

    RAISE NOTICE 'Creating index';

    CREATE INDEX idnx_fias_house_room_tmp_aoguid ON fias_house_room_tmp (aoguid);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
