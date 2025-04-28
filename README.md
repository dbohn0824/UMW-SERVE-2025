# SERVE Volunteer Management System
## Purpose
This project is the result of a semester's worth of collaboration among UMW students. The goal of the project was to create a web application that SERVE could utilize to manage SERVE volunteers and staff accounts. 

## Authors
The ODHS Medicine Tracker is based on an old open source project named "Homebase". [Homebase](https://a.link.will.go.here/) was originally developed for the Ronald McDonald Houses in Maine and Rhode Island by Oliver Radwan, Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.

Modifications to the original Homebase code were made by the Fall 2022 semester's group of students. That team consisted of Jeremy Buechler, Rebecca Daniel, Luke Gentry, Christopher Herriott, Ryan Persinger, and Jennifer Wells.

A major overhaul to the existing system took place during the Spring 2023 semester, throwing out and restructuring many of the existing database tables. Very little original Homebase code remains. This team consisted of Lauren Knight, Zack Burnley, Matt Nguyen, Rishi Shankar, Alip Yalikun, and Tamra Arant. Every page and feature of the app was changed by this team.

The Gwyneth's Gifts VMS code was modified in the Fall of 2023, revamping the code into the present ODHS Medicine Tracker code. Many of the existing database tables were reused, and many other tables were added. Some portions of the software's functionality were reused from the Gwyneth's Gifts VMS code. Other functions were created to fill the needs of the ODHS Medicine Tracker. The team that made these modifications and changes consisted of Garrett Moore, Artis Hart, Riley Tugeau, Julia Barnes, Ryan Warren, and Collin Rugless.

The ODHS Medicine Tracker code was modified in the Fall of 2024, changing the code to the present STEP VA Volunteer Management System code. Many existing database tables were reused or renamed, and some others were added. Some files and portions of the software's functionality were reused from ODHS Medicine Tracker, while other functions were created to fill the needs of STEP VA Volunteer Management. The team which made changes and new addtions consisted of Ava Donley, Thomas Held, Madison McCarty, Noah Stafford, Jayden Wynes, Gary Young, and Imaad Qureshi.

Spring 2025 authors: Dylan Bohn, Luke Busch, Jackson Carmack, Mariel Couvillion, Marshall Denson, Katie Heyn, Avi Lewers modified the STEP VA code base to be tailored for SERVE (Stafford Emergency Reliefe throug Volunteer Efforts)

## User Types
There are 3 types of users (also referred to as 'roles') within SERVE.
* Admins
* Superadmins
* Volunteers

Admins can generate reports over a specified date range, register new volunteers, archive volunteers, vizualize volunteer data over a specified date range, export volunteer data as a CSV file, view the check-in status of all volunteers and check-in or check-out volunteers.  

Superadmins hold all the powers of an admin, and additionally are able to create/delete staff accounts, and permenently delete volunteers from the system.

Volunteers view their total hours, check-in/check-out, download a form to sign up for volunteering and they can send a message to all superadmins, requesting to recieve a letter of proof of service. 

There is also a root admin account with username 'vmsroot'. The default password for this account is 'vmsroot'. This account has hardcoded Admin privileges. It is crucial that this account be given a strong password and that the password be easily remembered, as it cannot easily be reset. This account should be used for system administration purposes only.

## Features
Below is an in-depth list of features that were implemented within the system
* User registration and log in
* Dashboard
* Volunteer Management
  * check-in/check-out to start tracking volunteer hours
  * sign up new volunteers
  * archive volunteers
  * visualize all volunteer data as a bar graph within a specified date range
  * Export all volunteer data within a specified date range. 
  * Delete volunteers 
  * view all volunteer check-in statuses 
* Staff management 
  * register new staff 
  * change staff password
  * delete staff acounts 
* Reports (print-friendly)
  * Volunteer Hour Reports
  * Volunteer report displaying total unique volunteers, total hours, and hours by volunteer
  over a specified time period. 
* Notification system, with notifications generated when
  * A volunteer has requested sign-up
  * A volunteer has been registered
  * A volunteer has requested a proof of service letter
  * A volunteer has been deleted
  * A Staff member has been added
  * A Staff member has been deleted. 

## Design Documentation
Several types of diagrams describing the design of the SERVE, including sequence diagrams and use case diagrams, are available. Please contact Dr. Polack for access.

## "localhost" Installation
Below are the steps required to run the project on your local machine for development and/or testing purposes.
1. [Download and install XAMPP](https://www.apachefriends.org/download.html)
2. Open a terminal/command prompt and change directory to your XAMPP install's htdocs folder
  * For Mac, the htdocs path is `/Applications/XAMPP/xamppfiles/htdocs`
  * For Ubuntu, the htdocs path is `/opt/lampp/htdocs/`
  * For Windows, the htdocs path is `C:\xampp\htdocs`
3. Clone the SERVE repo by running the following command: 'git clone https://github.com/dbohn0824/UMW-SERVE-2025.git'

4. Start the XAMPP MySQL server and Apache server
5. Open the PHPMyAdmin console by navigating to [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
6. Create a new database named `servedb`. With the database created, navigate to it by clicking on it in the lefthand pane
7. Import the `serve.sql` file located in `UMW-SERVE-2025/sql` into this new database
8. Create a new user by navigating to `Privileges -> New -> Add user account`
9. Enter the following credentials for the new user:
  * Name: `servedb`
  * Hostname: `Local`
  * Password: `servedb`
  * Leave everything else untouched
10. Navigate to [http://localhost/UMW-SERVE-2025/login.php] 
11. Log into the root user account using the username `vmsroot` with password `vmsroot`

Installation is now complete.

## Reset root user credentials
In the event of being locked out of the root user, the following steps will allow resetting the root user's login credentials:
1. Using the PHPMyAdmin console, delete the `vmsroot` user row from the `dbPersons` table
2. Clear the SiteGround dynamic cache [using the steps outlined below](#clearing-the-siteground-cache)
3. In the UMW-SERVE-2025 directory, navigate to the file 'registerStaff.php'
4. place '//' as the first characters on the following lines in the file like so:

    //if (!isset($_SESSION['access_level'])){
      //  header('Location: login.php');
   // } elseif($_SESSION['access_level'] < 3) {
     //   header('Location: index.php');
       // die();
    //}
5. Save the file and in your browser, navigate to http://localhost/UMW-SERVE-2025/registerStaff.php
6. Fill out the form with the following credentials:
    First Name: root
    Last Name: root
    Street Address: 123
    City: staff
    state: Virginia
    Zip Code: 12345
    Email: root
    Phone Number: 5555555555
    Username: vmsroot
    Password: vmsroot
    Re-enter Password: vmsroot
    Click 'Submit'
4. You may now log in with the username and password `vmsroot`

## Platform
Dr. Polack chose SiteGrounds as the platform on which to host the project. Below are some guides on how to manage the live project.

### SiteGround Dashboard
Access to the SiteGround Dashboard requires a SiteGround account with access. Access is managed by Dr. Polack.

### Localhost to Siteground
Follow these steps to transfter your localhost version of the SERVE code to Siteground. For a video tutorial on how to complete these steps, contact Dr. Polack.
1. Create an FTP Account on Siteground, giving you the necessary FTP credentials. (Hostname, Username, Password, Port)
2. Use FTP File Transfer Software (Filezilla, etc.) to transfer the files from your localhost folders to your siteground folders using the FTP credentials from step 1.
3. Create the following database-related credentials on Siteground under the MySQL tab:
  - Database - Create the database for the siteground version under the Databases tab in the MySQL Manager by selecting the 'Create Database' button. Database name is auto-generated and can be changed if you like.
  - User - Create a user for the database by either selecting the 'Create User' button under the Users tab, or by selecting the 'Add New User' button from the newly created database under the Databases tab. User name is auto-generated and can be changed  if you like.
  - Password - Created when user is created. Password is auto generated and can be changed if you like.
4. Access the newly created database by navigating to the PHPMyAdmin tab and selecting the 'Access PHPMyAdmin' button. This will redirect you to the PHPMyAdmin page for the database you just created. Navigate to the new database by selecting it from the database list on the left side of the page.
5. Select the 'Import' option from the database options at the top of the page. Select the 'Choose File' button and import the "serve.sql" file from your software files.
  - Ensure that you're keeping your .sql file up to date in order to reduce errors in your Siteground code. Keep in mind that Siteground is case-sensitive, and your database names in the Siteground files must be identical to the database names in the database.
6. Navigate to the 'dbInfo.php' page in your Siteground files. Inside the connect() function, you will see a series of PHP variables. ($host, $database, $user, $pass) Change the server name in the 'if' statement to the name of your server, and change the $database, $user, and $pass variables to the database name, user name, and password that you created in step 3. 

### Clearing the SiteGround cache
#### Chrome
1. Open Chrome and click on the three-dot menu icon in the top-right corner.
2. Navigate to **More Tools** > **Clear Browsing Data**.
3. In the pop-up window:
   - Select the **Time Range** (e.g., "Last 24 hours" or "All time").
   - Check the box for **Cached images and files**.
4. Click **Clear Data**.

#### Safari
1. Open Safari and click on **Safari** in the menu bar at the top of the screen.
2. Select **Preferences** > **Privacy**.
3. Click the **Manage Website Data** button.
4. In the pop-up window, click **Remove All**, then confirm by selecting **Remove Now**.

Clearing your cache will help ensure that you're seeing the latest updates to the application. If you continue experiencing issues, consider reaching out for further support.

## External Libraries and APIs
The version of jQuery used by the system is stored locally within the repo, within the lib folder. jQuery was used to implement form validation and the hiding/showing of certain page elements. Additionally, the Font Awesome library was used for some of the icon pictures. This library is linked in the headers of some files "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css".

chart.js is a javascript library used for data visualization. In our source code, we include a statment, "<script src = "https://cdn.jsdelivr.net/npm/chart.js"></script>" which tells the browser upong rendering the page, to import all library dependencies from this address for the chart.js library

dompdf: is an additional libary utilized in our source code. We utilized comoser, which is an open source dependency manager to download all dependencies for the library localy to the source code, which is all included within the vendor director of this repo. 

## Potential Improvements
Below is a list of improvements that could be made to the system in subsequent semesters.
* CSS styling could be made to be more consistent
* Implementing some layer of protection on the volunteer side of the application to 
prevent random peopel from accessing it and spaming super admins with request for volunteering etc. 
* ability to import sql files to dynamically change the data from which much of the site operates 
* Additonal items related to volunteer training

## License
The project remains under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl.txt).

## Acknowledgements
Thank you to Dr. Polack and SERVE for the chance to work on this exciting project. A lot of love went into making it!