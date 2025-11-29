Emergency Contact Information Management System
============================================

This system is designed for disaster response teams to manage emergency contact information and track incidents. It now includes a complete user authentication system for enhanced security.

System Requirements:
--------------------
- XAMPP (or similar LAMP/WAMP stack)
- Web browser
- MySQL database

Installation Instructions:
--------------------------
1. Install XAMPP on your computer
2. Copy all files from this folder to your XAMPP htdocs directory 
   (usually C:\xampp\htdocs\emergency-contact-system)
3. Start XAMPP Control Panel
4. Start Apache and MySQL services
5. Open phpMyAdmin (usually http://localhost/phpmyadmin)
6. Create a new database named "emergency_contact_system"
7. Import the database_schema.sql file into the new database
8. Access the system through your web browser at http://localhost/EMERGENCY%20MANAGEMENT%20SYSTEM/login.php
9. Register a new user account or log in with existing credentials

File Structure:
---------------
- /assets/css/style.css - Styling for the application
- /contacts/ - CRUD operations for contacts
- /incidents/ - CRUD operations for incidents
- /includes/ - Database connection and functions
- database_schema.sql - Database structure (clean schema without sample data)
- select_queries.sql - Sample SQL queries for testing
- index.php - Main dashboard page
- login.php - User login page
- register.php - User registration page
- logout.php - User logout functionality
- query_console.php - SQL query testing interface

Features:
---------
1. User Authentication
   - Secure login and registration system
   - Session management with automatic expiration
   - User roles (admin, responder, viewer)
   - Password hashing for security

2. Contact Management
   - Add, edit, view, and delete emergency contacts
   - Store contact information (name, phone, email, address)
   - Organize contacts by category

3. Incident Management
   - Track emergency incidents
   - Record incident details, status, and timeline
   - Manage incident lifecycle (active, resolved, closed)

4. Query Console
   - Execute custom SQL queries
   - Pre-loaded sample queries for common operations
   - Results display with error handling

5. Dashboard
   - Overview statistics
   - Recent activity tracking
   - Visual charts for incident status

Database Tables:
----------------
1. contacts - Stores contact information
2. contact_categories - Categories for organizing contacts
3. contact_category_assignments - Links contacts to categories
4. communication_methods - Available communication methods
5. contact_communication_preferences - Preferred communication methods for contacts
6. emergency_incidents - Tracks emergency incidents
7. contact_logs - Records communication attempts
8. users - System user accounts with roles
9. user_sessions - Secure session tracking

User Authentication:
--------------------
The system now requires all users to log in before accessing any functionality:
- New users can register through the registration page
- Existing users can log in with their credentials
- Sessions are securely managed with automatic timeout
- Users can log out at any time

Testing:
--------
The select_queries.sql file contains sample queries demonstrating various SQL operations:
- Basic SELECT queries
- Filtering with WHERE clause
- Sorting with ORDER BY
- Aggregation functions (COUNT, MAX, MIN)
- JOIN operations
- GROUP BY and HAVING clauses

Troubleshooting:
----------------
If you encounter issues:
1. Ensure XAMPP services are running
2. Check that the database name matches in db_connection.php
3. Verify file permissions
4. Check Apache error logs for PHP errors
5. Ensure all database tables are properly imported

For support, contact the system administrator.