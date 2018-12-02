# Printer-Facilitator
## Languages Used:
Front-End: PHP

Back-End: MYSQL

For printing automation : Python

## Get Started
### Pre-Requisites:
PHP Server

MySQL Server

Configured mail() functions in php
### Setting up the Website:
Download the repository.

Extract the contents of the zip file to your default server location.
#### For Windows users using xampp:
Default server location is C:/xampp/htdocs/
#### For Linux users:
Default server location is /var/www/html/

### Setting up the Databse:
Import the printq.sql file to your MySQL Server

## Database Info:
### main Table(for logging in):
Contains the roll number, password(hashed using SHA-256 encryption), level(student/admin) and balance of all the users who created an account.
### printhistory Table(for maintaining the print jobs):
Contains the Print Job ID, pdfname while uploading, new pdf name, Roll Number of the student, Page Range(s), Number of Copies, Color/B&W, Cost, Print Status and Collection Status
### payments Table(for maintaining payment history):
Contains Payment ID, Roll number of the student, Amount Paid and Timestamp(date&time)
## Website Info:
#### database.php:
Establishes the connection to mysql database 'printq'. Included in all the php files which requires the database
#### signup.php(for signing up new users): 
Accepts roll number(for e.g: 160060066) and password as input and sends an email containing verification code to corresponding email address(for e.g: 160060066@iitdh.ac.in) and redirects to verification.php
#### verification.php(for verification of the code sent to email): 
Accepts verification code as input and redirects to action.php if the code is verified successfully
#### login.php(for logging in existing users): 
Accepts username and password as input and redirects to action.php if logged in successfully
#### action.php(for user): 
Accepts file(pdf),page range(s),number of copies,color/b&w as input. Uploads the file to the server if the above fields are entered correctly and adds it to print jobs
#### printhistory.php(for user):
Displays the print history of the current user
#### admin.php(for admin):
Displays the print history of all the users and can change the print status and collection status of a print job. Even though the print status is automatically updated if the print job is done, admin may manually change it
#### payments.php(for admin):
To update the balance of a user if any payment is made and payment history is maintained
#### payhistory.php(for admin):
Contains the payment history of users
#### logout.php(for logging out):
Clears all the session variables and the user is logged out
