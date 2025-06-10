DELIMITER $$
CREATE PROCEDURE AssignCrewToFlight(
    IN input_flight_id INT,
    IN input_crew_id INT,
    IN input_role VARCHAR(50)
)
BEGIN
    INSERT INTO assigned_to (flight_id, crew_id, role)
    VALUES (input_flight_id, input_crew_id, input_role);
END$$
DELIMITER ;
