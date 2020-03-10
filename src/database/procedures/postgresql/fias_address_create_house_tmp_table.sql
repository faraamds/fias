CREATE OR REPLACE FUNCTION fias_address_create_house_tmp_table()
    RETURNS VOID AS $BODY$
DECLARE

    var_aoguid UUID;
    var_houseguid UUID;
    var_house TEXT;
    var_building TEXT;
    var_structure TEXT;

BEGIN

    DROP TABLE IF EXISTS fias_house_tmp;
    CREATE TABLE fias_house_tmp
    (aoguid UUID, houseguid UUID, house TEXT, buildnum TEXT, ao_count SMALLINT);

    FOR var_aoguid, var_houseguid, var_house, var_building, var_structure
        IN SELECT MIN(aoguid::TEXT)::UUID, houseguid,
                  string_agg(distinct housenum, ', '),
                  string_agg(distinct buildnum, ', '),
                  string_agg(distinct strucnum , ', ')
           FROM fias_house GROUP BY houseguid
    LOOP

        INSERT INTO fias_house_tmp (aoguid, houseguid, house, buildnum, ao_count)
        VALUES (var_aoguid, var_houseguid,
                (CASE WHEN var_house IS NULL THEN '' ELSE 'д дом ' || var_house END),
                (CASE WHEN var_building IS NULL THEN '' ELSE 'к корп корпус ' || var_building END ||
                 CASE WHEN var_structure IS NULL THEN '' ELSE ', стр строение ' || var_structure END),
                (100 +
                 (CASE WHEN var_building IS NULL THEN 0 ELSE 10 END) +
                 (CASE WHEN var_structure IS NULL THEN 0 ELSE 10 END))
                 );

    END LOOP;

    raise notice 'creating houseguid index';
    CREATE INDEX idnx_fias_house_tmp_houseguid ON fias_house_tmp (houseguid);

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
