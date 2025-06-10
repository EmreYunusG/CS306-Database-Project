DELIMITER //

CREATE TRIGGER CancelFlightIfNoTickets
AFTER DELETE ON Ticket
FOR EACH ROW
BEGIN
    IF NOT EXISTS (
        SELECT * FROM Ticket WHERE flight_id = OLD.flight_id
    ) THEN
        UPDATE Flight
        SET status = 'Cancelled'
        WHERE flight_id = OLD.flight_id;
    END IF;
END;
//

DELIMITER ;
