CREATE OR REPLACE FUNCTION fias_get_search_by_ids(in_ids BIGINT[])
    RETURNS TABLE(out_aoguid UUID, out_houseguid UUID, out_roomguid UUID, out_address TEXT) AS $BODY$
DECLARE

    var_id BIGINT;

BEGIN

    FOREACH var_id IN ARRAY in_ids
    LOOP
        SELECT aoguid, houseguid, roomguid, address INTO out_aoguid, out_houseguid, out_roomguid, out_address
        FROM fias_address_object_help_search
        WHERE id = var_id;

        RETURN NEXT;
    END LOOP;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
