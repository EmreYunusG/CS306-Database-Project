# CS306 - Database Project

A course project for CS306 at Sabancı University.  
Includes a web-based support ticket system built with PHP and MySQL.

---

## 🛠️ Features

- Admin interface to manage support tickets  
- Stored procedures and triggers for automated DB logic  
- User ticket submission with validation  
- HTML forms with PHP backend  
- Relational schema and normalization  
- MySQL triggers for dynamic updates  
- Sample data and test queries  

---

## 📁 Structure

- `php/`  
  Contains all front-end and back-end PHP files.
  - `admin/`: Admin panel for viewing, resolving, and commenting on support tickets.
  - `user/`: User interface for triggers, procedures and also submitting and viewing tickets.
  - `config.php`: Database connection configuration.

- `sql/`  
  Contains SQL scripts for schema, triggers, and procedures.
  - `schema.sql`: Table definitions and relational schema.
  - `inserts.sql`: Sample data for testing.
  - `triggers/`: All trigger definitions (e.g., `CancelFlightIfNoTickets`).
  - `procedures/`: Stored procedures used in the system.

- `Tables and Inserts.pdf`  
  Describes the database schema, table structures, and sample insertions.

- `Procedures and Triggers.pdf`  
  Explains the logic behind stored procedures and triggers with examples.

