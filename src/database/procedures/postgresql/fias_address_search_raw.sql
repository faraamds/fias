CREATE OR REPLACE FUNCTION fias_address_search_raw(in_q TEXT, in_regioncode INT DEFAULT NULL)
    RETURNS TABLE(address TEXT, target_aoguid UUID, target_aoid UUID, address_weight INT) AS $BODY$
DECLARE

    var_address_object RECORD;
    var_addr TEXT;
    var_addr_uuid UUID;
    var_result TEXT [][][];

BEGIN

    CREATE TEMPORARY TABLE tmp_fias_address_object (aoguid UUID, parentguid UUID, aoid UUID, nextid UUID, formalname VARCHAR(123), shortname VARCHAR(10), weight INT, regionweight INT) ON COMMIT DROP;
    CREATE INDEX inx_tmp_fias_address_object_aoguid ON tmp_fias_address_object (aoguid);
    CREATE INDEX inx_tmp_fias_address_object_parentguid ON tmp_fias_address_object (parentguid);
    CREATE INDEX inx_tmp_fias_address_object_aoid ON tmp_fias_address_object (aoid);
    CREATE INDEX inx_tmp_fias_address_object_nextid ON tmp_fias_address_object (nextid);

    INSERT INTO tmp_fias_address_object
    select s.aoguid, s.parentguid, s.aoid, s.nextid, s.formalname, s.shortname, s.weight,
           ((sum(weight) over (partition by s.regioncode)) + s.weight) as regionweight
    from (select *,
                 rank() over (partition by fias_address_object.aoguid order by fias_address_object.enddate desc),
                 ((fias_address_object.areacode::INT = 0)::INT * 1000 + (fias_address_object.citycode::INT = 0)::INT * 100 + (fias_address_object.streetcode::INT = 0)::INT * 10 +
                  (fias_address_object.ctarcode::INT = 0)::INT * 1) as weight
          from fias_address_object,
               to_tsquery(in_q) as q
          where CASE WHEN in_regioncode IS NOT NULL THEN fias_address_object.regioncode::INT=in_regioncode ELSE 1=1 END
            AND fias_address_object.aoguid IS NOT NULL
            AND to_tsvector('russian', fias_address_object.formalname || ' ' || fias_address_object.shortname) @@ q) s
    where s.rank = 1
    order by regionweight desc, weight desc;

    FOR var_address_object IN SELECT *
                              FROM tmp_fias_address_object
                              WHERE aoguid NOT IN
                                    (SELECT parentguid FROM tmp_fias_address_object WHERE parentguid IS NOT NULL)
                              order by regionweight desc, weight desc
        LOOP

            var_addr := concat(var_address_object.formalname, ' ', var_address_object.shortname);
            var_addr_uuid := var_address_object.aoguid;

                        var_result := fias_address_search_get_parent(var_address_object.parentguid);

             WHILE var_result IS NOT NULL
                 LOOP

                     var_addr := concat(var_result[1], ', ', var_addr);
                     var_addr_uuid := var_result[2];

                     var_result := fias_address_search_get_parent(var_addr_uuid);

                 END LOOP;

            address := var_addr;
            address_weight := var_address_object.weight;
            target_aoid := var_address_object.aoid;
            target_aoguid := var_address_object.aoguid;

            RETURN NEXT;
        END LOOP;


END;


$BODY$ LANGUAGE plpgsql VOLATILE;
