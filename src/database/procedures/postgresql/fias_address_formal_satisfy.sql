CREATE OR REPLACE FUNCTION fias_address_formal_satisfy(in_aoguid UUID, in_q TEXT)
    RETURNS TEXT AS $BODY$
DECLARE

    var_address_object RECORD;
    var_result TEXT;
    var_or_query tsquery;
    var_guid UUID;
BEGIN

    var_or_query := ((replace(plainto_tsquery('russian', in_q)::TEXT, ' & ', ':* | ') || ':*')::tsquery);

    SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE aoguid = in_aoguid
        AND to_tsvector('russian', formalname) @@ var_or_query
        ORDER BY enddate DESC
        LIMIT 1;

    IF var_address_object IS NULL THEN

        SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE aoguid = in_aoguid
        ORDER BY enddate DESC
        LIMIT 1;

    END IF;

    var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname);

    WHILE var_address_object.parentguid IS NOT NULL
        LOOP
            var_guid := var_address_object.parentguid;

            SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE aoguid = var_guid
              AND to_tsvector('russian', formalname) @@ var_or_query
            ORDER BY enddate DESC
            LIMIT 1;

            IF var_address_object IS NULL THEN

                SELECT * INTO var_address_object
                FROM fias_address_object
                WHERE aoguid = var_guid
                ORDER BY enddate DESC
                LIMIT 1;

            END IF;

            var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname, ', ', var_result);

        END LOOP;

    RETURN var_result;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
