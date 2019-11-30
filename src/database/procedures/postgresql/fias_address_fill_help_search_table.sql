CREATE OR REPLACE FUNCTION fias_address_fill_help_search_table()
    RETURNS VOID AS $BODY$
DECLARE

    var_aoguid TEXT;
    var_regioncode VARCHAR(2);
    var_i INT :=0;

BEGIN

    TRUNCATE TABLE fias_address_object_help_search;
    DROP INDEX IF EXISTS idnx_fias_address_object_help_search_address;
    DROP INDEX IF EXISTS idnx_fias_address_object_help_search_aoguid;
    DROP INDEX IF EXISTS idnx_fias_address_object_help_search_regioncode;

    FOR var_aoguid, var_regioncode IN SELECT MIN(aoguid::TEXT), min(regioncode) FROM fias_address_object a1 WHERE NOT EXISTS (
        SELECT 1 FROM fias_address_object a2 WHERE a2.parentguid=a1.aoguid
        ) GROUP BY aoguid LOOP

        INSERT into fias_address_object_help_search (aoguid, regioncode, address)
        VALUES (var_aoguid::UUID, var_regioncode, fias_address_formal_whole_history(var_aoguid::UUID));

        var_i:=var_i+1;

        raise notice '%', var_i;


    END LOOP;

    CREATE INDEX idnx_fias_address_object_help_search_address on fias_address_object_help_search  USING gin (to_tsvector('russian', address));
    CREATE INDEX idnx_fias_address_object_help_search_aoguid ON fias_address_object_help_search (aoguid);
    CREATE INDEX idnx_fias_address_object_help_search_regioncode ON fias_address_object_help_search (regioncode);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
