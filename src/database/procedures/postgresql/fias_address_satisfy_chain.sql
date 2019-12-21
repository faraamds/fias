CREATE OR REPLACE FUNCTION fias_address_satisfy_chain(in_aoguid UUID, in_q TEXT)
    RETURNS TABLE(aoguid UUID, formalname VARCHAR(120), shortname VARCHAR(10), aolevel INT, sortorder INT) AS $BODY$
DECLARE

    var_address_object RECORD;
    var_or_query tsquery;
    var_guid UUID;
    i INT := 1;
BEGIN

    var_or_query := (replace(fias_get_tsquery(in_q)::TEXT, '&', '|')::tsquery);

    SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE fias_address_object.aoguid=in_aoguid
          AND to_tsvector('russian', fias_address_object.formalname) @@ var_or_query
        ORDER BY fias_address_object.enddate DESC
        LIMIT 1;

    IF var_address_object IS NULL THEN

        SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE fias_address_object.aoguid=in_aoguid
            ORDER BY fias_address_object.enddate DESC
            LIMIT 1;

    END IF;

    aoguid := var_address_object.aoguid;
    formalname := var_address_object.formalname;
    shortname := var_address_object.shortname;
    aolevel := var_address_object.aolevel;
    sortorder := i;

    RETURN NEXT;

    WHILE var_address_object.parentguid IS NOT NULL
        LOOP

            i := i + 1;

            var_guid := var_address_object.parentguid;

            SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE fias_address_object.aoguid = var_guid
              AND to_tsvector('russian', fias_address_object.formalname) @@ var_or_query
            ORDER BY fias_address_object.enddate DESC
            LIMIT 1;

            IF var_address_object IS NULL THEN

                SELECT * INTO var_address_object
                FROM fias_address_object
                WHERE fias_address_object.aoguid = var_guid
                ORDER BY fias_address_object.enddate DESC
                LIMIT 1;

            END IF;

            aoguid := var_address_object.aoguid;
            formalname := var_address_object.formalname;
            shortname := var_address_object.shortname;
            aolevel := var_address_object.aolevel;
            sortorder := i;

            RETURN NEXT;

        END LOOP;

    RETURN;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
