# NHLSports web application

## Prerequisites

- Apache server (with PHP 7 or higher installed)
- *MYSQL* or *MariaDB* database
- packages from ***composer.json***
- connection to the internet (only for *JQUERY*)
- a browser supporting HTML5 and CSS3

## Getting started

1. Clone this repository in the directory where your server looks for files to serve on your domain (e.g. htdocs)<br>

``git clone https://github.com/alvndotexe/HBO-Sports.git``

2. Create a new database

``CREATE DATABASE 'Database name here'``

3. Import the file ``HBO-Sports/Database/nhl-sports.sql`` in the database you created


4. In the **Code** folder (*HBO-Sports/Code*) create a file called **credentials.php** (if it doesn't exist)


5. Add this lines to the file you created:

```
<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "nhlsports";
 ?>
 ```

and change the credentials to the ones you are using to connect to the database.

## Functionalities

- A user can register and login
- The user can select the event types they want to see based on month and sport type
- There is the possibility for users to book seats for an event. When a seat is booked, the user will receive a
  confirmation email containing the tickets they bought in PDF format.

=================================

- Users are able to change their details (such as credentials or subscriptions) via a user panel.
- Administrators can add/modify/remove events or sports from the database. Also, they can get an overview of who is
  attending an event. 
