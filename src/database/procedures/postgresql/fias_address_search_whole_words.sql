CREATE OR REPLACE FUNCTION fias_address_search_whole_words(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 50)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT) AS $BODY$
DECLARE

BEGIN

    IF (select count(*) > 0 from regexp_matches(in_q, '\d')) THEN

        RETURN QUERY
            SELECT r.aoguid, r.houseguid, r.roomguid, r.actual_address
            FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit, false, true) r
            ORDER BY r.ao_count, r.rank;
    ELSE

            RETURN QUERY
                SELECT r.aoguid, r.houseguid, r.roomguid, r.actual_address
                FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit, true, true) r
                ORDER BY r.ao_count, r.rank;

    END IF;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;

