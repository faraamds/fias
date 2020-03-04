CREATE OR REPLACE FUNCTION fias_address_fill_help_search_table_address_full()
    RETURNS VOID AS $BODY$
DECLARE

BEGIN

    DROP TABLE IF EXISTS fias_address_object_help_search;
    DROP SEQUENCE IF EXISTS fias_address_object_help_search_seq;
    CREATE SEQUENCE fias_address_object_help_search_seq;
    CREATE TABLE fias_address_object_help_search
    (id BIGINT, aoguid UUID NOT NULL, houseguid UUID, roomguid UUID, regioncode VARCHAR(2),
     ao_count INT, address TEXT, actual_address TEXT);

    INSERT INTO fias_address_object_help_search
        SELECT nextval('fias_address_object_help_search_seq'), aoguid, null,null,
               regioncode, ao_count, address, actual_address
        FROM fias_ao_tmp;

    INSERT INTO fias_address_object_help_search
        SELECT nextval('fias_address_object_help_search_seq'),
               hrt.aoguid, hrt.houseguid, hrt.roomguid,at.regioncode, hrt.ao_count+at.ao_count,
               (at.address || ', ' || coalesce(hrt.house, '') || ', ' || coalesce(hrt.flatnumber, '')
                    || ', ' || coalesce(hrt.buildnum, '')),
               (at.actual_address || ', ' || hrt.address)
    FROM fias_house_room_tmp hrt JOIN fias_ao_tmp at ON hrt.aoguid=at.aoguid;

    raise notice 'creating id index';
    CREATE INDEX idnx_fias_address_object_help_search_id ON fias_address_object_help_search (id);
    raise notice 'creating aoguid index';
    CREATE INDEX idnx_fias_address_object_help_search_aoguid ON fias_address_object_help_search (aoguid);
    raise notice 'creating houseguid index';
    CREATE INDEX idnx_fias_address_object_help_search_houseguid ON fias_address_object_help_search (houseguid);
    raise notice 'creating regioncode index';
    CREATE INDEX idnx_fias_address_object_help_search_regioncode ON fias_address_object_help_search (regioncode);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
