CREATE OR REPLACE FUNCTION fias_address_fill_help_search_table_address_full()
    RETURNS VOID AS $BODY$
DECLARE

    var_aoguid TEXT;
    var_regioncode VARCHAR(2);
    var_i INT :=0;
    var_search_result TEXT[];
    var_house TEXT;
    var_flatnumber TEXT;
    var_buildnum TEXT;
    var_houseguid UUID;
    var_roomguid UUID;

BEGIN

    --     TRUNCATE TABLE fias_address_object_help_search;
--     DROP INDEX IF EXISTS idnx_fias_address_object_help_search_address;
--     DROP INDEX IF EXISTS idnx_fias_address_object_help_search_aoguid;
--     DROP INDEX IF EXISTS idnx_fias_address_object_help_search_regioncode;
--     DROP INDEX IF EXISTS indx_fias_address_object_help_search_ao_count;

    DROP TABLE IF EXISTS fias_address_object_help_search;
    CREATE TABLE fias_address_object_help_search
    (aoguid UUID NOT NULL, houseguid UUID, roomguid UUID, regioncode VARCHAR(2),
     ao_count INT, address TEXT, house VARCHAR(255), flatnumber VARCHAR(255), buildnum varchar(255));

    FOR var_aoguid, var_regioncode IN SELECT aoguid::TEXT, MIN(regioncode) FROM fias_address_object GROUP BY aoguid LOOP

            var_search_result := fias_address_formal_whole_history_with_count(var_aoguid::UUID);
            var_houseguid := NULL;
            var_roomguid := NULL;

            INSERT into fias_address_object_help_search (aoguid, houseguid, roomguid, regioncode, address, ao_count)
            VALUES (var_aoguid::UUID, var_houseguid, var_roomguid, var_regioncode, var_search_result[1], var_search_result[2]::INT);

            FOR var_houseguid, var_roomguid, var_house, var_flatnumber, var_buildnum IN SELECT houseguid, roomguid, house, flatnumber, buildnum
                                                                                        FROM fias_house_room_tmp
                                                                                        WHERE fias_house_room_tmp.aoguid=var_aoguid::UUID LOOP

                    INSERT into fias_address_object_help_search (aoguid, houseguid, roomguid, regioncode, address, ao_count, house, flatnumber, buildnum)
                    VALUES (var_aoguid::UUID, var_houseguid, var_roomguid, var_regioncode, var_search_result[1], var_search_result[2]::INT + 1, var_house, var_flatnumber, var_buildnum);

                END LOOP;

            var_i:=var_i+1;

            raise notice '%', var_i;

        END LOOP;

    CREATE INDEX idnx_fias_address_object_help_search_address on fias_address_object_help_search  USING GIN((setweight(to_tsvector('russian', coalesce(address, '')), 'A') || setweight(to_tsvector('russian', coalesce(house, '')), 'B') || setweight(to_tsvector('russian', coalesce(flatnumber, '')), 'C') || setweight(to_tsvector('russian', coalesce(buildnum, '')), 'D')));
    CREATE INDEX idnx_fias_address_object_help_search_aoguid ON fias_address_object_help_search (aoguid);
    CREATE INDEX idnx_fias_address_object_help_search_houseguid ON fias_address_object_help_search (houseguid);
    CREATE INDEX idnx_fias_address_object_help_search_regioncode ON fias_address_object_help_search (regioncode);
    CREATE INDEX indx_fias_address_object_help_search_ao_count ON fias_address_object_help_search (ao_count);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
