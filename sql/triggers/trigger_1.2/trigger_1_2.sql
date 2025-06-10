DELIMITER $$
CREATE TRIGGER ReactivateFlightIfTicketAdded
AFTER INSERT ON Ticket
FOR EACH ROW
BEGIN
    IF (SELECT status FROM Flight WHERE flight_id = NEW.flight_id) = 'Cancelled' THEN
        UPDATE Flight SET status = 'On Time' WHERE flight_id = NEW.flight_id;
    END IF;
END$$
DELIMITER ;
