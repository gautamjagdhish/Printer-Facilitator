# Printer-Facilitator
## Languages Used:
 PHP

MYSQL

Python and bash

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

### Setting up Bash on Windows:
If running on windows, install a linux subsystem, preferably Ubuntu 18.04.

Installation instructions for the subsystem can be found here:

https://docs.microsoft.com/en-us/windows/wsl/install-win10

#### i. inotifytools package
    apt-get install inotify-tools
    
Please refer to the following link for further details:

https://github.com/rvoicilas/inotify-tools/wiki
#### ii. PyPDF2 package for python
    sudo apt-get install python3-pip

    pip3 install PyPDF2

Please refer to the following page for further details:

https://pypi.org/project/PyPDF2/
    
### Setting the script directories and running the scripts
 In the line 2 of 'pythonrunner.sh' in  master/uploads, change the directory to the current location of this script. In a linux terminal, run the following command (the terminal should be open in the same directory as the file):

	chmod +x ./pythonrunner.sh 
  
This will allow execution of the script. Run the script by the following command:

	./pythonrunner.sh
  
In the line 2 of 'print.sh' in  master/uploads/print_jobs, change the directory to the current location of this script. In a linux terminal, run the following command (the terminal should be open in the same directory as the file):

	chmod +x ./print.sh 
  
Run the file using the following command:

	./print.sh
  
The last two steps will set up the file monitoring system. These are triggered whenever a new file is detected, and run the python scripts, which perform the splitting, merging and printing of the uploaded pdf files. Note that a separate terminal window is required for each of the previous two files discussed. 
## Database Info:
### main Table(for logging in):
Contains the roll number, password(hashed using SHA-256 encryption), level(student/admin) and balance of all the users who created an account.
### printhistory Table(for maintaining the print jobs):
Contains the Print Job ID, pdfname while uploading, new pdf name, Roll Number of the student, Page Range(s), Number of Copies, Color/B&W, Cost, Print Status and Collection Status
### payments Table(for maintaining payment history):
Contains Payment ID, Roll number of the student, Amount Paid and Timestamp(date&time)
## PHP Info:
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
## How the Python Scripts Works ?
#### pythonrunner.sh
The script, when activated, runs a file system monitor which activates 'slicer.py' whenever a new file is added to this directory.
#### master/uploads/slicer.py
The python script uses the libraries os and PyPDF2. os is used to manipulate files on the drive. PyPDF2 is a package used for manipulating pdf files using python.

It slices only the required page range(s) from the pdf file and moves it to 'print_jobs' folder
#### print.sh
The script, when activated, runs a file system monitor which activates 'print_lp.py' whenever a new file is added to this directory.
#### print_lp.py
The python script verifies whether the files have already been printed, else it prints them using the 'lp' command and updates the 'print status' of this print job in the database and moves the file to 'completed_print_jobs'
