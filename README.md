## Home Office
#### Author:
Balázs Szolcsánszki

#### Used Technologies (backend)
- PHP 7.4
- Laravel 8 (Socialite, Sanctum)
- MariaDB (MySQL)

#### About the project
This is a multi-role, modular application's REST API backend.
The idea came from the gmail performance and login problems of mine.
You can check your e-mails, the weather, news, etc.
These are the currently planned modules, further development conceivable.
The program uses OAuth2 with Github and Google identification.
Google authorization (login) is mandatory for using the GMail API (e-mails module).


#### Currently available routes
(Not deployed yet, running on Apache virtualhost!)
- Readme file: http://homeoffice.com/api
##### E-mails:
- Mails CRUD: http://homeoffice.com/api/mail  
Google specific query parameters for filtering, provided as values with parameter key "q":
Example: http://homeoffice.com/api/mail/options?q=is:unread+in:inbox
- Mails with options: http://homeoffice.com/api/mail/options
- Mail with options: http://homeoffice.com/api/mail/options/{gmail_id}
##### Registration/login:
- Registration with username + password: http://homeoffice.com/api/registration/simple
- Registration with Github/Goggle (via Oauth)
http://homeoffice.com/api/auth and  
    /google-redirect, /google-callback  
    /github-redirect, /github-callback  
- Login: http://homeoffice.com/api/login
- Logout: http://homeoffice.com/api/logout

#### Setup
- Create .env file by copying env.example and setting the required params  
Database, API keys are mandatory for the functionalities! If you need these, check the following pages:  
**[Google](https://developers.google.com)**  
**[Github](https://docs.github.com/en)**

- Run: ​ composer install ​
- Run: ​ php artisan migrate ​

##### Running
Currently, the application is in development mode. 
It is advisable to create an Apache virtualhost and deploy to the corresponding folder on the local machine.
