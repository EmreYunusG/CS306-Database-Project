DELIMITER $$
CREATE PROCEDURE GetPassengerFlights(IN input_passenger_id INT)
BEGIN
    SELECT 
        T.ticket_id,
        F.flight_number,
        A.name AS airline,
        DA.name AS departure_airport,
        AA.name AS arrival_airport,
        F.departure_time,
        F.arrival_time,
        T.seat_number,
        T.class,
        T.price
    FROM Ticket T
    JOIN Flight F ON T.flight_id = F.flight_id
    JOIN Airline A ON F.airline_id = A.airline_id
    JOIN Airport DA ON F.departure_airport_id = DA.airport_id
    JOIN Airport AA ON F.arrival_airport_id = AA.airport_id
    WHERE T.passenger_id = input_passenger_id;
END$$
DELIMITER ;
