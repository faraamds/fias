CREATE OR REPLACE FUNCTION fias_get_search_by_ids(in_ids BIGINT[], in_check_query TEXT)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT) AS $BODY$
DECLARE

    var_id BIGINT;

BEGIN

    FOREACH var_id IN ARRAY in_ids
    LOOP
        SELECT fhs.aoguid, fhs.houseguid, fhs.roomguid,
               fias_address_house_room(fhs.aoguid, to_tsquery(in_check_query), fhs.houseguid, fhs.roomguid)
            INTO aoguid, houseguid, roomguid, actual_address
        FROM fias_address_object_help_search fhs
        WHERE id = var_id;

        RETURN NEXT;
    END LOOP;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
