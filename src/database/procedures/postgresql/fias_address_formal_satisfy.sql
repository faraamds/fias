CREATE OR REPLACE FUNCTION fias_address_formal_satisfy(in_aoguid UUID, in_q TEXT)
    RETURNS TEXT AS $BODY$
DECLARE

    var_address_object RECORD;
    var_result TEXT;
    var_or_query tsquery;
    var_guid UUID;
    var_ex_formalname TEXT;
    var_ao_name TEXT;

BEGIN
    var_or_query := (replace(in_q, ' & ', ' | '))::tsquery;

    SELECT formalname INTO var_ex_formalname
        FROM fias_address_object
        WHERE aoguid = in_aoguid
        AND to_tsvector('russian', formalname) @@ var_or_query
        ORDER BY enddate DESC
        LIMIT 1;

        SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE aoguid = in_aoguid
        ORDER BY enddate DESC
        LIMIT 1;

    var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname);
    IF var_ex_formalname != var_address_object.formalname THEN
        var_result := var_result || ' (бывш. ' || var_ex_formalname || ')';
    END IF;

    WHILE var_address_object.parentguid IS NOT NULL
        LOOP
            var_guid := var_address_object.parentguid;

            SELECT formalname INTO var_ex_formalname
            FROM fias_address_object
            WHERE aoguid = var_guid
              AND to_tsvector('russian', formalname) @@ var_or_query
            ORDER BY enddate DESC
            LIMIT 1;

            SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE aoguid = var_guid
            ORDER BY enddate DESC
            LIMIT 1;

            var_ao_name := concat(var_address_object.formalname, ' ', var_address_object.shortname);
            IF var_ex_formalname != var_address_object.formalname THEN
                var_ao_name := var_ao_name || ' (бывш. ' || var_ex_formalname || ')';
            END IF;

            var_result := concat(var_ao_name, ', ', var_result);

        END LOOP;

    RETURN var_result;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
