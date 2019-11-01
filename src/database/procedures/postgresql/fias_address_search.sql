CREATE OR REPLACE FUNCTION fias_address_search(in_q TEXT, in_regioncode INT DEFAULT NULL, in_limit INT DEFAULT 10)
    RETURNS TABLE(address TEXT, actual_address TEXT, target_aoguid UUID, target_aoid UUID) AS $BODY$
DECLARE

BEGIN

    RETURN QUERY
        WITH found as (
                          SELECT fias_address_search_raw.address,
                                 (SELECT *
                                  FROM fias_address_formal(fias_address_search_raw.target_aoguid)) as actual_address,
                                 fias_address_search_raw.target_aoguid,
                                 fias_address_search_raw.target_aoid
                          FROM fias_address_search_raw(in_q, in_regioncode),
                               to_tsquery(in_q) as q
                          ORDER BY ts_rank(to_tsvector('russian', fias_address_search_raw.address), q) DESC,
                                   address_weight DESC
                          LIMIT in_limit
                      )
        SELECT found.address, found.actual_address, found.target_aoguid, found.target_aoid
        FROM found, to_tsquery(replace(in_q, '|', '&')) as q
        WHERE to_tsvector('russian', found.actual_address) @@ q;

END;


$BODY$ LANGUAGE plpgsql VOLATILE;
