CREATE OR REPLACE FUNCTION fias_address_create_ao_tmp_table()
    RETURNS VOID AS $BODY$
DECLARE

    var_aoguid TEXT;
    var_regioncode VARCHAR(2);
    var_search_result TEXT[];

BEGIN

    DROP TABLE IF EXISTS fias_ao_tmp;
    CREATE TABLE fias_ao_tmp
    (aoguid UUID NOT NULL, regioncode VARCHAR(2), ao_count INT, address TEXT);

    FOR var_aoguid, var_regioncode IN SELECT aoguid::TEXT, MIN(regioncode) FROM fias_address_object GROUP BY aoguid LOOP

            var_search_result := fias_address_formal_whole_history_with_count(var_aoguid::UUID);

            INSERT into fias_ao_tmp (aoguid, regioncode, ao_count, address)
            VALUES (var_aoguid::UUID, var_regioncode, var_search_result[2]::INT,
                    coalesce(var_search_result[1], '')
                    );

        END LOOP;

    CREATE INDEX idnx_fias_fias_ao_tmp_aoguid ON fias_ao_tmp (aoguid);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
