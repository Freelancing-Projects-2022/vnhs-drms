# Document Request Management System
The purpose of this system is to provide a online platform for students to request needed scholastic documents.

## Description
This system was built using PHP, Bootstrap and XAMPP. This also uses Google OAuth 2.0 to Access Gmail API for the email facility.

## Getting Started

### Dependencies

* Operating System: Windows 10 
* XAMPP Version 8.0.6
* Apache 2.4.47
* MariaDB 10.4.19
* PHP 8.0.6
* Browsers: Chrome, Firefox, Edge (Latest Version)

### Installing

* Download the system files here.
* Download XAMPP Version 8.0.6.
* Paste the system files in the XAMPP htocs folder.
* Open XAMPP PhpMyAdmin and create a database with a name "vnhs_drms".
* Click the database, and click "IMPORT".
* An upload window will open up, select the file "vnhs_drms.sql", and click Go.

### Configuring OAuth 2.0 to Access Google Gmail API

* Go to Google Developers Console. 
```
https://console.cloud.google.com/
```
* Choose “Select a project” and make a new one. Name it and hit the “Create” button.
* On the left bar, choose “Library” and move to the API Library page. Find Gmail API and click on it. Enable the API for the chosen project.
* Once the API is enabled, you will be taken to a Credentials dashboard. There, select the “OAuth Client ID” from the Create Credentials dropdown list.
* Then you’ll see the “Configure consent” button. By clicking, you’ll get to the page where you can simply enter the name of your application and specify the authorized domains. Please fill in the other fields if you wish.
* Click “Save” and choose your app type (Web App, Android, Chrome App, iOS, or other). After that, name your OAuth Client ID. Also, enter JavaScript sources and redirect domains to use with requests from the browser or web server. Click “Create” to complete.
* Have a copy of the API Client ID and Client Secret you will use that to connect the system to the api.

### Executing program

* To run the system, open your browser and type in
```
http://localhost/vnhs-drms/
```

