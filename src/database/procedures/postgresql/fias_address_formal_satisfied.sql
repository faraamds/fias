CREATE OR REPLACE FUNCTION fias_address_formal_satisfied(in_aoguid UUID, in_q TSQUERY)
    RETURNS TEXT AS $BODY$
DECLARE

    var_address_object RECORD;
    var_postalcode VARCHAR(6);
    var_result TEXT;
    var_any_query TSQUERY;
    i INT;
BEGIN

    var_any_query := replace(in_q::TEXT, '&','|')::TSQUERY;

    SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE aoguid=in_aoguid
        AND to_tsvector('russian', fias_address_object.formalname) @@ var_any_query
        ORDER BY enddate DESC
        LIMIT 1;

    IF var_address_object IS NULL THEN
        SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE aoguid=in_aoguid
        ORDER BY enddate DESC
        LIMIT 1;
    END IF;

    var_postalcode := var_address_object.postalcode;
    var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname);

    WHILE var_address_object.parentguid IS NOT NULL
        LOOP

            SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE aoguid = var_address_object.parentguid
            AND to_tsvector('russian', fias_address_object.formalname) @@ var_any_query
            ORDER BY enddate DESC
            LIMIT 1;

            IF var_address_object IS NULL THEN
                SELECT * INTO var_address_object
                FROM fias_address_object
                WHERE aoguid = var_address_object.parentguid
                ORDER BY enddate DESC
                LIMIT 1;
            END IF;

            var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname, ', ', var_result);

        END LOOP;

    RETURN concat(var_postalcode, ', ' , var_result);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
