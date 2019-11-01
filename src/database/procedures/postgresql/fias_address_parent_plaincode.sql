CREATE OR REPLACE FUNCTION fias_address_parent_plaincode(in_plaincode TEXT)
    RETURNS TEXT AS $BODY$
DECLARE

    var_pure_code       TEXT;
    var_cur_code        TEXT;
    var_pattern         TEXT := '^(';
    var_closing_pattern TEXT := ')$';

BEGIN

    var_pure_code := regexp_replace(in_plaincode, '0*$', '');

    -- REGION

    IF length(var_pure_code) < 2 THEN
        RETURN NULL;
    END IF;

    var_cur_code := left(var_pure_code, 2);
    var_pattern := var_pattern || var_cur_code || '0+';

    -- AREA

    IF length(var_pure_code) < 5 THEN
        RETURN var_pattern || var_closing_pattern;
    END IF;

    var_cur_code := left(var_pure_code, 5);
    var_pattern := var_pattern || '|' || var_cur_code || '0+';

    -- CITY

    IF length(var_pure_code) < 8 THEN
        RETURN var_pattern || var_closing_pattern;
    END IF;

    var_cur_code := left(var_pure_code, 8);
    var_pattern := var_pattern || '|' || var_cur_code || '0+';

    -- PLACE

    IF length(var_pure_code) < 11 THEN
        RETURN var_pattern || var_closing_pattern;
    END IF;

    var_cur_code := left(var_pure_code, 11);
    RETURN var_pattern || '|' || var_cur_code || '0+' || var_closing_pattern;

END;


$BODY$ LANGUAGE plpgsql VOLATILE;
