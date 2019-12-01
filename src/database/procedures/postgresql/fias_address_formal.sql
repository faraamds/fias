CREATE OR REPLACE FUNCTION fias_address_formal(in_aoguid UUID, in_aoid UUID DEFAULT NULL)
    RETURNS TEXT AS $BODY$
DECLARE

    var_address_object RECORD;
    var_result TEXT;
    i INT;
BEGIN

    SELECT * INTO var_address_object
        FROM fias_address_object
        WHERE aoguid=in_aoguid
        AND CASE WHEN in_aoid IS NULL THEN 1=1 ELSE aoid=in_aoid END
        ORDER BY enddate DESC
        LIMIT 1;

    var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname);

    WHILE var_address_object.parentguid IS NOT NULL
        LOOP

            SELECT * INTO var_address_object
            FROM fias_address_object
            WHERE aoguid = var_address_object.parentguid
            ORDER BY enddate DESC
            LIMIT 1;

            var_result := concat(var_address_object.formalname, ' ', var_address_object.shortname, ', ', var_result);

        END LOOP;

    RETURN var_result;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
