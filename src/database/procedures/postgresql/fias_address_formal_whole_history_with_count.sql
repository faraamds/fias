CREATE OR REPLACE FUNCTION fias_address_formal_whole_history_with_count(in_aoguid UUID)
    RETURNS TEXT[] AS $BODY$
DECLARE

    var_name TEXT[];
    var_aoguids UUID[];
    var_prev_aoguids UUID[];
    var_result TEXT;
    var_processed_guids UUID[] := ARRAY[in_aoguid]::UUID[];
    var_count INT := 1;

BEGIN

    SELECT array_agg(distinct formalname || ' ' || shortname), array_agg(distinct parentguid::TEXT)
        INTO var_name, var_aoguids
        FROM fias_address_object
        WHERE aoguid=in_aoguid;

    var_result :=  concat('(', (SELECT string_agg(distinct n, ', ') FROM unnest(var_name) n) , ')');

    WHILE var_aoguids IS NOT NULL
        LOOP
            var_prev_aoguids := var_aoguids;

            SELECT array_agg(distinct formalname || ' ' || shortname), array_agg(distinct parentguid::TEXT)
            INTO var_name, var_aoguids
            FROM fias_address_object
            WHERE aoguid IN (SELECT unnest(var_aoguids))
            AND aoguid NOT IN (SELECT unnest(var_processed_guids));

            IF array_length(var_name, 1) > 0 THEN
                var_result := concat((SELECT string_agg(distinct n, ', ') FROM unnest(var_name) n), ', ', var_result);
            END IF;

            var_processed_guids := var_processed_guids || var_prev_aoguids;
            var_count := var_count + 1;

        END LOOP;

    RETURN ARRAY[var_result, var_count::TEXT]::TEXT[];

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
