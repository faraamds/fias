CREATE OR REPLACE FUNCTION fias_address_search_get_parent_satisfy(in_aoguid UUID, in_q TSQUERY)
    RETURNS UUID AS $BODY$
DECLARE

    var_pguid UUID;
    var_address TEXT;

BEGIN

    SELECT parentguid INTO var_pguid
        FROM fias_address_object
        WHERE aoguid = in_aoguid
        AND to_tsvector('russian', fias_address_object.formalname) @@ (replace(in_q::TEXT, '&','|')::TSQUERY)
        ORDER BY enddate DESC LIMIT 1;

    IF var_pguid IS NULL THEN

        SELECT parentguid INTO var_pguid
        FROM fias_address_object
        WHERE aoguid = in_aoguid
        ORDER BY enddate DESC LIMIT 1;

    END IF;

    IF var_pguid IS NULL THEN

        RETURN NULL;

    END IF;

    var_address := fias_address_formal_satisfied(var_pguid, in_q);

    IF to_tsvector('russian', var_address) @@ in_q THEN

        RETURN var_pguid;

    END IF;

    RETURN NULL;

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
