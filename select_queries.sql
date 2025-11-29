-- Emergency Contact Information Management System
-- Sample SELECT Queries for Database Testing

-- 1. Basic Select Query
SELECT * FROM contacts;

-- 2. Selecting Specific Columns
SELECT first_name, last_name, phone_number FROM contacts;

-- 3. Using WHERE Clause
SELECT * FROM contacts WHERE city = 'Anytown';

-- 4. Using ORDER BY Clause
SELECT * FROM contacts ORDER BY last_name, first_name;

-- 5. Using DISTINCT Keyword
SELECT DISTINCT city FROM contacts;

-- 6. Using LIMIT (MySQL)
SELECT * FROM contacts LIMIT 5;

-- 7. Using LIKE Operator (Pattern Matching)
SELECT * FROM contacts WHERE last_name LIKE 'S%';

-- 8. Using BETWEEN Operator
SELECT * FROM contacts WHERE id BETWEEN 1 AND 3;

-- 9. Using IN Operator
SELECT * FROM contacts WHERE city IN ('Anytown', 'Othertown');

-- 10. Using AND / OR Conditions
SELECT * FROM contacts WHERE city = 'Anytown' AND state = 'CA';
SELECT * FROM contacts WHERE city = 'Anytown' OR city = 'Othertown';

-- 11. Using Aggregate Functions
-- COUNT
SELECT COUNT(*) AS total_contacts FROM contacts;

-- MAX
SELECT MAX(id) AS max_contact_id FROM contacts;

-- MIN
SELECT MIN(id) AS min_contact_id FROM contacts;

-- 12. Using GROUP BY
SELECT city, COUNT(*) AS contact_count FROM contacts GROUP BY city;

-- 13. Using HAVING Clause
SELECT city, COUNT(*) AS contact_count FROM contacts GROUP BY city HAVING COUNT(*) > 1;

-- 14. Using Aliases
SELECT first_name AS "First Name", last_name AS "Last Name", phone_number AS "Phone" FROM contacts;

-- Join Queries
-- Get contacts with their categories
SELECT c.first_name, c.last_name, cc.category_name 
FROM contacts c
JOIN contact_category_assignments ca ON c.id = ca.contact_id
JOIN contact_categories cc ON ca.category_id = cc.id;

-- Get incidents with their status
SELECT incident_name, incident_type, status FROM emergency_incidents;

-- Complex query to get contact information with categories
SELECT 
    c.first_name,
    c.last_name,
    c.phone_number,
    c.email,
    cc.category_name
FROM contacts c
LEFT JOIN contact_category_assignments ca ON c.id = ca.contact_id
LEFT JOIN contact_categories cc ON ca.category_id = cc.id
ORDER BY c.last_name, c.first_name;