CREATE OR REPLACE FUNCTION fias_address_search_get_parent(in_parentguid UUID)
    RETURNS TEXT[] AS $BODY$
DECLARE

    var_result RECORD;

BEGIN

    SELECT formalname, shortname, parentguid, weight INTO var_result FROM tmp_fias_address_object WHERE aoguid = in_parentguid LIMIT 1;

    IF var_result IS NULL THEN
        RETURN NULL;
    END IF;

    RETURN ARRAY[concat(var_result.formalname, ' ', var_result.shortname) :: TEXT, var_result.parentguid :: TEXT, var_result.weight::TEXT];

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
