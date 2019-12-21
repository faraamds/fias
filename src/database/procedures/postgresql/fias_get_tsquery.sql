CREATE OR REPLACE FUNCTION fias_get_tsquery(in_q TEXT)
    RETURNS tsquery AS $BODY$
DECLARE

    var_keywords TEXT[];
    var_processed_keywords TEXT[] := ARRAY[]::TEXT[];
    var_keyword TEXT;
    var_processed_keyword TEXT;

BEGIN

    var_keywords := regexp_split_to_array(plainto_tsquery('russian', in_q)::TEXT, ' & ');

    IF (array_length(var_keywords, 1) < 2) THEN
        RETURN NULL;
    END IF;

    FOREACH var_keyword IN ARRAY var_keywords
        LOOP
            IF (SELECT COUNT(*) > 0 FROM regexp_matches(replace(var_keyword, $$'$$, ''), '\D')) THEN
                var_processed_keyword := var_keyword || ':*';
            ELSE
                var_processed_keyword := var_keyword;
            END IF;
            var_processed_keywords := var_processed_keywords || var_processed_keyword;
        END LOOP;

    RETURN array_to_string(var_processed_keywords, ' & ')::TSQUERY;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
