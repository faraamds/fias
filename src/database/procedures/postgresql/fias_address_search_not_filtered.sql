CREATE OR REPLACE FUNCTION fias_address_search_not_filtered(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 50, in_exclude_huiseguid BOOL DEFAULT FALSE)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT, rank REAL, ao_count INT) AS $BODY$
DECLARE

    var_query tsquery;

BEGIN

    var_query := to_tsquery(in_q);

    RETURN QUERY
          SELECT fias_address_object_help_search.aoguid, fias_address_object_help_search.houseguid, fias_address_object_help_search.roomguid,
                 (SELECT * FROM fias_address_house_room(fias_address_object_help_search.aoguid, in_q, fias_address_object_help_search.houseguid, fias_address_object_help_search.roomguid)) as actual_address,
                 fias_address_object_help_search.vector <=> var_query as rank,
                 fias_address_object_help_search.ao_count
          FROM fias_address_object_help_search

          WHERE CASE WHEN in_regioncode IS NOT NULL THEN fias_address_object_help_search.regioncode=in_regioncode ELSE 1=1 END
          AND CASE WHEN in_exclude_huiseguid THEN fias_address_object_help_search.houseguid IS NULL ELSE 1=1 END
          AND fias_address_object_help_search.vector @@ var_query
          ORDER BY fias_address_object_help_search.ao_count <=> 1
          LIMIT in_limit;

EXCEPTION WHEN others THEN
    RETURN;
END;

$BODY$ LANGUAGE plpgsql VOLATILE;

