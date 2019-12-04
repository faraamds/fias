CREATE OR REPLACE FUNCTION fias_address_search(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 10)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT) AS $BODY$
DECLARE

BEGIN

    RETURN QUERY
          SELECT fias_address_object_help_search.aoguid, fias_address_object_help_search.houseguid, fias_address_object_help_search.roomguid,
                 (SELECT * FROM fias_address_house_room(fias_address_object_help_search.aoguid, in_q, fias_address_object_help_search.houseguid, fias_address_object_help_search.roomguid)) as actual_address
          FROM fias_address_object_help_search,
               plainto_tsquery('russian', in_q) as q

          WHERE CASE WHEN in_regioncode IS NOT NULL THEN fias_address_object_help_search.regioncode=in_regioncode ELSE 1=1 END
          AND to_tsvector('russian', fias_address_object_help_search.address) @@ q

          ORDER BY ao_count, ts_rank(to_tsvector('russian', fias_address_object_help_search.address), q) DESC
          LIMIT in_limit;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
