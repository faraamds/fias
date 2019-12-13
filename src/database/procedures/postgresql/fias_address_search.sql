CREATE OR REPLACE FUNCTION fias_address_search(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 50)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT) AS $BODY$
DECLARE

BEGIN

    IF (select count(*) > 0 from regexp_matches(in_q, '\d')) THEN

        RETURN QUERY
            SELECT * FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit);
    ELSE

        IF (SELECT COUNT(*) > 0 FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit) q
            WHERE q.houseguid IS NULL) THEN

            RETURN QUERY
                SELECT * FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit) q
                    WHERE q.houseguid IS NULL;
        ELSE
            RETURN QUERY
                SELECT * FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit);
        END IF;

    END IF;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;

