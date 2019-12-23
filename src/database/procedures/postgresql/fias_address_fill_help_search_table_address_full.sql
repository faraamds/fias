CREATE OR REPLACE FUNCTION fias_address_fill_help_search_table_address_full()
    RETURNS VOID AS $BODY$
DECLARE

BEGIN

    DROP TABLE IF EXISTS fias_address_object_help_search;
    CREATE TABLE fias_address_object_help_search
    (aoguid UUID NOT NULL, houseguid UUID, roomguid UUID, regioncode VARCHAR(2),
     ao_count INT, vector tsvector);

    INSERT INTO fias_address_object_help_search
        SELECT aoguid, null,null, regioncode, ao_count, vector
        FROM fias_ao_tmp;

    INSERT INTO fias_address_object_help_search
        SELECT hrt.aoguid, hrt.houseguid, hrt.roomguid,at.regioncode, hrt.ao_count+at.ao_count,
               (at.vector || setweight(to_tsvector('russian', coalesce(hrt.house, '')), 'B') || setweight(
                       to_tsvector('russian', coalesce(hrt.flatnumber, '')), 'C') ||
                setweight(to_tsvector('russian', coalesce(hrt.buildnum, '')), 'D'))
        FROM fias_house_room_tmp hrt JOIN fias_ao_tmp at ON hrt.aoguid=at.aoguid;

    raise notice 'creating address vector index';
--     CREATE INDEX idnx_fias_address_object_help_search_address_gin on fias_address_object_help_search  USING GIN(vector);
----     CREATE INDEX idnx_fias_address_object_help_search_address_rum on fias_address_object_help_search  USING rum(vector rum_tsvector_ops);
    CREATE INDEX idnx_fias_address_object_help_search_address_rum on fias_address_object_help_search  USING rum(vector rum_tsvector_addon_ops, ao_count rum_int4_ops) WITH (attach = 'ao_count', to = 'vector');
    raise notice 'creating aoguid index';
    CREATE INDEX idnx_fias_address_object_help_search_aoguid ON fias_address_object_help_search (aoguid);
    raise notice 'creating houseguid index';
    CREATE INDEX idnx_fias_address_object_help_search_houseguid ON fias_address_object_help_search (houseguid);
    raise notice 'creating regioncode index';
    CREATE INDEX idnx_fias_address_object_help_search_regioncode ON fias_address_object_help_search (regioncode);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
