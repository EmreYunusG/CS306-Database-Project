DELIMITER $$
CREATE PROCEDURE GetFlightSummary(IN input_flight_id INT)
BEGIN
    SELECT 
        F.flight_id,
        F.flight_number,
        F.status,
        A.model AS aircraft_model,
        A.capacity AS aircraft_capacity,
        (SELECT COUNT(*) FROM Ticket WHERE flight_id = input_flight_id) AS total_tickets_sold,
        (SELECT COUNT(DISTINCT passenger_id) FROM Ticket WHERE flight_id = input_flight_id) AS total_passengers,
        (SELECT IFNULL(SUM(price), 0) FROM Ticket WHERE flight_id = input_flight_id) AS total_revenue,
        (SELECT COUNT(*) 
         FROM Baggage B 
         JOIN Ticket T ON B.ticket_id = T.ticket_id 
         WHERE T.flight_id = input_flight_id) AS total_baggage_items,
        (SELECT COUNT(*) 
         FROM assigned_to 
         WHERE flight_id = input_flight_id) AS total_crew_assigned
    FROM Flight F
    JOIN Aircraft A ON F.aircraft_id = A.aircraft_id
    WHERE F.flight_id = input_flight_id;
END$$
DELIMITER ;
