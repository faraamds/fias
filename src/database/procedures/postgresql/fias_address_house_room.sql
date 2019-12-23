CREATE OR REPLACE FUNCTION fias_address_house_room(in_aoguid UUID, in_q tsquery, in_houseguid UUID DEFAULT NULL, in_roomguid UUID DEFAULT NULL)
    RETURNS TEXT AS $BODY$
DECLARE

    var_address TEXT;
    var_house TEXT;
    var_room TEXT;
    i INT;
BEGIN

    var_address := fias_address_formal_satisfy(in_aoguid, in_q);

    SELECT (CASE WHEN fias_house.housenum IS NULL THEN '' ELSE ', дом ' || fias_house.housenum END ||
            CASE WHEN fias_house.buildnum IS NULL THEN '' ELSE ', корпус ' || fias_house.buildnum END ||
            CASE WHEN fias_house.strucnum IS NULL THEN '' ELSE ', строение ' || fias_house.strucnum END
           ) INTO var_house
    FROM fias_house WHERE houseguid = in_houseguid
    ORDER BY enddate DESC LIMIT 1;

    SELECT (
            CASE WHEN fias_room.flatnumber IS NULL THEN '' ELSE ', квартира ' || fias_room.flatnumber END ||
            CASE WHEN fias_room.roomnumber IS NULL THEN '' ELSE ', комната ' || fias_room.roomnumber END
            ) INTO var_room
    FROM fias_room WHERE roomguid = in_roomguid
    ORDER BY enddate DESC LIMIT 1;

    RETURN var_address || COALESCE(var_house, '') || COALESCE(var_room, '');

END;

$BODY$ LANGUAGE plpgsql VOLATILE;
