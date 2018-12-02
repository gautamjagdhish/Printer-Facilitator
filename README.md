# Printer-Facilitator
## Functions of various files:
### signup.php(for signing up new users): 
accepts roll number(for e.g: 160060066) and password as input and sends an email containing verification code to corresponding email address(for e.g: 160060066@iitdh.ac.in) and redirects to verification.php
### verification.php(for verification of code sent to email): 
accepts verification code as input and redirects to action.php if the code is verified successfully
### login.php(for logging in existing users): 
accepts username and password as input and redirects to action.php if logged in successfully
### action.php(for user): 
accepts file(pdf),page range(s),number of copies,color/b&w as input. Uploads the file to the server if the above fields are entered correctly
### printhistory.php(for user):

### admin.php(for admin):

### payments.php(for admin):

### payhistory.php(for admin):

### logout.php(for logging out):
