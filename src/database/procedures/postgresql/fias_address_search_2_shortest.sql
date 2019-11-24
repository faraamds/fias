CREATE OR REPLACE FUNCTION fias_address_search_2_shortest(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 10)
    RETURNS TABLE(aoguid UUID, actual_address TEXT) AS $BODY$
DECLARE

    var_addresses UUID[] := ARRAY[]::UUID[];
    var_address UUID;
    var_shortest_address UUID;
    var_test_address UUID;
    var_tsquery TSQUERY;

BEGIN

    var_tsquery := plainto_tsquery(in_q);

    FOR var_address IN SELECT fias_address_object_help_search.aoguid
                       FROM fias_address_object_help_search

                       WHERE CASE WHEN in_regioncode IS NOT NULL THEN fias_address_object_help_search.regioncode=in_regioncode ELSE 1=1 END
                         AND to_tsvector('russian', fias_address_object_help_search.address) @@ var_tsquery

                       ORDER BY ts_rank(to_tsvector('russian', fias_address_object_help_search.address), var_tsquery) DESC
        LOOP

            var_shortest_address := var_address;
            var_test_address := fias_address_search_get_parent_satisfy(var_shortest_address, var_tsquery);

            WHILE var_test_address IS NOT NULL
                LOOP
                    var_shortest_address := var_test_address;
                    var_test_address := fias_address_search_get_parent_satisfy(var_shortest_address, var_tsquery);
                END LOOP;

            IF NOT var_addresses @> ARRAY[var_shortest_address] THEN
                var_addresses := var_addresses || var_shortest_address;
            END IF;

            IF array_length(var_addresses, 1) >= in_limit THEN
                EXIT;
            END IF;

        END LOOP;

    RETURN QUERY
          SELECT guid,
                 (SELECT * FROM fias_address_formal(guid)) as actual_address
          FROM unnest(var_addresses) guid;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
