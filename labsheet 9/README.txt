LAB SHEET 9 - MCA108P-AS09
Student-friendly PHP and MySQL files

FILES
1.sql       Database and tables for Question 1
2.php       Common MySQL connection file for the other PHP pages
3.php-20.php  Individual files for Questions 3 to 20
style.css   Common page design
uploads/    Product images uploaded in Question 14

HOW TO RUN
1. Install XAMPP or another local PHP + MySQL server.
2. Start Apache and MySQL.
3. Open phpMyAdmin and import 1.sql.
4. Copy this complete folder into htdocs.
5. Open http://localhost/Lab_Sheet_9/3.php to register a user.
6. Login using 4.php. The dashboard is 5.php.
7. Change the MySQL username/password in 2.php if your system uses different details.

IMPORTANT
- Keep all numbered files and style.css in the same folder.
- Question 2 is the shared database connection file; other pages include it.
- Question 9 and Question 10 need a product ID in the URL, for example:
  9.php?id=1
  10.php?id=1
- Question 14 needs the uploads folder to be writable by PHP.
- Question 19 requires a logged-in user and items in the session cart.
- Register a user first before testing login and checkout.
- These are learning/lab examples. For a real website, add CSRF protection,
  stronger authorization checks, and production server configuration.
