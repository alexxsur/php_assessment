# Assignment: list of server information

The php_assessment repository contains 2 main directories:

* **assessment-symfony-backend**

The directory assessment-symfony-backend contains the backend API developed using Symfony 6.3.5 and PHP 8.1.

* **assessment-angular-frontend**

The directory assessment-angular-frontend contains the frontend, developed using Angular 16.2.8.



## Instructions to run the project

**1.** Clone the repository to your local environment

   `git clone https://github.com/alexxsur/php_assessment.git`

**2.** In the terminal, go to the assessment-symfony-backend directory in the path where the composer.json file is located and run composer install
`composer install`, depending on the PHP installation, It may also be necessary to install some PHP extensions such as:
* php8.1-mbstring
* php8.1-zip
* php8.1-dom
* php8.1-gd

**3.** Then you can run the command `symfony server:start` to start the Symfony Local Web Server

After being executed, it will show the url on which it is listening: generally "http://127.0.0.1:8000" we must take this url into account since we will later use it in our frontend project to make the API calls.

**4.** Now we can test the API endpoints using the url assigned by the Symfony Local Web Server, For example:

Unfiltered list of servers
* http://127.0.0.1:8000/server

List of locations
* http://127.0.0.1:8000/server/locations


**5.** In other terminal, go to the assessment-angular-frontend directory

Install Angular CLI  if it is not installed yet
`npm install -g @angular/cli`


**6.** Edit the file config.ts located in the assessment-angular-frontend/src/app/config/config.ts path, modify the **apiUrl** property which must contain the url obtained in step 3, example "http://127.0.0.1:8000" which is the url to the symfony api.

**7.** Return to the root of the "assessment-angular-frontend" directory where the package.json file is located and run npm install
`npm install` which will install the dependencies of the angular project


**8.** Then you can run the command `ng serve` to start a development server for an Angular
After being executed, it will show the url on which it is listening: generally "http://localhost:4200"

and this url is the one that we will bring to our browser to use the application, optionally we can use the --open parameter to automatically open the browser, example `ng serve --open`
