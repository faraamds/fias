CREATE OR REPLACE FUNCTION fias_address_create_help_search_short_table()
    RETURNS VOID AS $BODY$
DECLARE

    var_aoguid TEXT;
    var_regioncode VARCHAR(2);
    var_i INT :=0;
    var_search_result TEXT[];

BEGIN

    DROP TABLE IF EXISTS fias_address_object_help_search_short;
    CREATE TABLE fias_address_object_help_search_short AS
        SELECT * FROM fias_address_object_help_search
        WHERE regioncode='77' OR regioncode='50';

    CREATE INDEX idnx_fias_address_object_help_search_short_address_rum on fias_address_object_help_search_short
        USING rum(vector rum_tsvector_addon_ops, ao_count rum_int4_ops) WITH (attach = 'ao_count', to = 'vector');
END;

$BODY$ LANGUAGE plpgsql VOLATILE;
