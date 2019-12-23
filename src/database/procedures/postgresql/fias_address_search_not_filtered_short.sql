CREATE OR REPLACE FUNCTION fias_address_search_not_filtered_short(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 50, in_exclude_huiseguid BOOL DEFAULT FALSE, in_whole_words BOOL DEFAULT FALSE)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT, rank REAL, ao_count INT) AS $BODY$
DECLARE

    var_query tsquery;

BEGIN

    IF in_whole_words THEN
        var_query := plainto_tsquery(in_q);
    ELSE
        var_query := to_tsquery(in_q);
    END IF;

    RETURN QUERY
          SELECT fias_address_object_help_search_short.aoguid, fias_address_object_help_search_short.houseguid, fias_address_object_help_search_short.roomguid,
                 (SELECT * FROM fias_address_house_room(fias_address_object_help_search_short.aoguid, var_query, fias_address_object_help_search_short.houseguid, fias_address_object_help_search_short.roomguid)) as actual_address,
                 fias_address_object_help_search_short.vector <=> var_query as rank,
                 fias_address_object_help_search_short.ao_count
          FROM fias_address_object_help_search_short

          WHERE CASE WHEN in_regioncode IS NOT NULL THEN fias_address_object_help_search_short.regioncode=in_regioncode ELSE 1=1 END
          AND CASE WHEN in_exclude_huiseguid THEN fias_address_object_help_search_short.houseguid IS NULL ELSE 1=1 END
          AND fias_address_object_help_search_short.vector @@ var_query
          ORDER BY fias_address_object_help_search_short.ao_count <=> 1
          LIMIT in_limit;

EXCEPTION WHEN others THEN
    RETURN;
END;

$BODY$ LANGUAGE plpgsql VOLATILE;

