# Advisory report: Project Web Application

This document contains recommendations regarding the clients requirements for the project to be delivered.
This document is only a set of suggestions and opinions. The client **doesn't have to follow them.**

1. The user interface will look like the image attached to this document (mock-up design).

    - Every page will have a header and a footer which will slightly change content based on the user logged in;
    - The homepage should have a catchy interface, therefore we suggest adding an interactive rectangle with 4 most popular sport events to accessed in only click;
    - Below on the homepage we suggest to be displayed interesting or useful information regarding the company, which will catch the attention or increase the confidence of an possible client in the application;

2. There will be another page (sports tab) which will display all the sport events the application has.

    - In order for a user to see the details of that sport he/she has to log in. If the user is not logged in, once he/she pressed the specific sport, he/she will be redirected to a "log in" page;

3. The application will store all data in a database. All information will be exchanged using PHP and MariaDB. A database is needed for managing all the data in an structural and secure way, as well to be easily editable.

4. For security purposes all the sensible information a user might fill in (passwords), will be stored in an encrypted form, using an secure hashing algorithm.
   Bcrypt hashing algorithm is advised because of the following aspects:

    - it reduces the likelihood of brute force attacks;
    - it makes rainbow table attacks almost impossbile;
    - compared to other hashing algorithms bcrypt has additional security stepts (such as "salt" or "more rounds").

    Also, for security purposes the user must create a password which is:

    - 8 characters or more in length;
    - has at least one upper-case character;
    - has at least one digit;
    - has at least one special symbol.

5. An administrator will have the ability to add/delete/edit an event from a sport category.
