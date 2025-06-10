DELIMITER $$
CREATE TRIGGER AutoCalculateExtraBaggageFee
BEFORE INSERT ON Baggage
FOR EACH ROW
BEGIN
    IF NEW.weight > 25 THEN
        SET NEW.extra_fee = (NEW.weight - 25) * NEW.extra_fee;
    ELSE
        SET NEW.extra_fee = 0;
    END IF;
END$$
DELIMITER ;
