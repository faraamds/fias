CREATE OR REPLACE FUNCTION fias_address_search(in_q TEXT, in_regioncode VARCHAR(2) DEFAULT NULL, in_limit INT DEFAULT 50)
    RETURNS TABLE(aoguid UUID, houseguid UUID, roomguid UUID, actual_address TEXT) AS $BODY$
DECLARE

BEGIN

    IF (select count(*) > 0 from regexp_matches(in_q, '\d')) THEN

        RETURN QUERY
            SELECT * FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit);
    ELSE

            RETURN QUERY
                SELECT * FROM fias_address_search_not_filtered(in_q, in_regioncode, in_limit, true);

    END IF;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;

