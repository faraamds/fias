CREATE OR REPLACE FUNCTION fias_address_formal_whole_history(in_aoguid UUID)
    RETURNS TEXT AS $BODY$
DECLARE

    var_name TEXT[];
    var_aoguid UUID;
    var_result TEXT;
    var_processed_guids UUID[] := ARRAY[]::UUID[];

BEGIN

    SELECT array_agg(formalname || ' ' || shortname), min(parentguid::TEXT) INTO var_name, var_aoguid
        FROM fias_address_object
        WHERE aoguid=in_aoguid;

    var_result :=  concat('(', (SELECT string_agg(distinct n, ', ') FROM unnest(var_name) n) , ')');
    var_processed_guids := var_processed_guids || var_aoguid;

    WHILE var_aoguid IS NOT NULL
        LOOP

            SELECT array_agg(formalname || ' ' || shortname), min(parentguid::TEXT) INTO var_name, var_aoguid
            FROM fias_address_object
            WHERE aoguid = var_aoguid;

            var_result := concat('(', (SELECT string_agg(distinct n, ', ') FROM unnest(var_name) n) , ')', ', ', var_result);

            IF ARRAY[var_aoguid]::UUID[] <@ var_processed_guids THEN
                RAISE NOTICE 'LOOP REF IN %', var_aoguid;
                RETURN var_result;
            END IF;

            var_processed_guids := var_processed_guids || var_aoguid;

        END LOOP;

    RETURN var_result;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
