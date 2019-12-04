CREATE OR REPLACE FUNCTION fias_address_actual_chain(in_aoguid UUID)
    RETURNS TABLE(aoguid UUID, formalname VARCHAR(120), shortname VARCHAR(10), aolevel INT, sortorder INT) AS $BODY$
DECLARE

    var_address_object RECORD;
    i INT := 1;
BEGIN

    SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE fias_address_object.aoguid=in_aoguid
        ORDER BY fias_address_object.enddate DESC
        LIMIT 1;

    aoguid := var_address_object.aoguid;
    formalname := var_address_object.formalname;
    shortname := var_address_object.shortname;
    aolevel := var_address_object.aolevel;
    sortorder := i;

    RETURN NEXT;

    WHILE var_address_object.parentguid IS NOT NULL
        LOOP

            i := i + 1;

            SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE fias_address_object.aoguid = var_address_object.parentguid
            ORDER BY fias_address_object.enddate DESC
            LIMIT 1;

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
