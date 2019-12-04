CREATE OR REPLACE FUNCTION fias_address_fill_help_search_table_address_full()
    RETURNS VOID AS $BODY$
DECLARE

    var_aoguid TEXT;
    var_regioncode VARCHAR(2);
    var_i INT :=0;
    var_search_result TEXT[];
    var_house_room_part TEXT;
    var_houseguid UUID;
    var_roomguid UUID;
    var_is_houses_exists BOOL;

BEGIN

    TRUNCATE TABLE fias_address_object_help_search;
    DROP INDEX IF EXISTS idnx_fias_address_object_help_search_address;
    DROP INDEX IF EXISTS idnx_fias_address_object_help_search_aoguid;
    DROP INDEX IF EXISTS idnx_fias_address_object_help_search_regioncode;
    DROP INDEX IF EXISTS indx_fias_address_object_help_search_ao_count;

    FOR var_aoguid, var_regioncode IN SELECT MIN(aoguid::TEXT), MIN(regioncode) FROM fias_address_object GROUP BY aoguid LOOP

        var_search_result := fias_address_formal_whole_history_with_count(var_aoguid::UUID);
        var_is_houses_exists := FALSE;
        var_houseguid := NULL;
        var_roomguid := NULL;
        FOR var_houseguid, var_roomguid, var_house_room_part IN SELECT houseguid, roomguid, house_room
                FROM fias_house_room_tmp
                WHERE fias_house_room_tmp.aoguid=var_aoguid::UUID LOOP

            raise notice 'house_room %', var_house_room_part;

            IF var_house_room_part IS  NULL THEN
                var_house_room_part := '';
                var_houseguid := NULL;
                var_roomguid := NULL;
            ELSE
                var_house_room_part := ', ' || var_house_room_part;
            END IF;

            INSERT into fias_address_object_help_search (aoguid, houseguid, roomguid, regioncode, address, ao_count)
            VALUES (var_aoguid::UUID, var_houseguid, var_roomguid, var_regioncode, var_search_result[1] || var_house_room_part, var_search_result[2]::INT);

            var_is_houses_exists := TRUE;

        END LOOP;

        IF NOT var_is_houses_exists THEN

            INSERT into fias_address_object_help_search (aoguid, houseguid, roomguid, regioncode, address, ao_count)
            VALUES (var_aoguid::UUID, var_houseguid, var_roomguid, var_regioncode, var_search_result[1], var_search_result[2]::INT);

        END IF;

        var_i:=var_i+1;

        raise notice '%', var_i;

        END LOOP;

    CREATE INDEX idnx_fias_address_object_help_search_address on fias_address_object_help_search  USING gin (to_tsvector('russian', address));
    CREATE INDEX idnx_fias_address_object_help_search_aoguid ON fias_address_object_help_search (aoguid);
    CREATE INDEX idnx_fias_address_object_help_search_regioncode ON fias_address_object_help_search (regioncode);
    CREATE INDEX indx_fias_address_object_help_search_ao_count ON fias_address_object_help_search (ao_count);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
