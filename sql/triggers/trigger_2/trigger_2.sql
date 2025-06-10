DELIMITER $$
CREATE TRIGGER PreventOverbooking
BEFORE INSERT ON Ticket
FOR EACH ROW
BEGIN
    DECLARE capacity INT;
    DECLARE sold_tickets INT;
    SELECT A.capacity INTO capacity
    FROM Flight F
    JOIN Aircraft A ON F.aircraft_id = A.aircraft_id
    WHERE F.flight_id = NEW.flight_id;
    SELECT COUNT(*) INTO sold_tickets
    FROM Ticket
    WHERE flight_id = NEW.flight_id;
    IF sold_tickets >= capacity THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Flight is fully booked!';
    END IF;
END$$
DELIMITER ;
