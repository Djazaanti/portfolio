# PROJET 5 : MON PREMIER BLOG EN PHP

    PHP blog with portfolio. 

## REQUIRE
    PHP version >= 8.2 
    MySQL
    Web Server
    Twig
    Composer

## LIBRARIES
    PHPMailer via Composer

## INSTALLATION
    Clone this github code : git@github.com:Djazaanti/portfolio.git
    Update the project packages with the  << composer install >> command
    Install Twig without Symfony
    Import the SQL script into MySQL << Script_SQL P5.sql>>
    Execute the website in a browser << http://localhost>> 

## PERSONALIZATION
    ### for Database connect : files on model function dbConnect()
    DB_NAME=...
    DB_USER=...
    DB_PASS=...
    DB_HOST=...
    DB_DRIVER=...
    # Database connect

    ### for send Mailler connect : file ContactController.PHP function sendEmail()
    MAIL_USERNAME=...
    MAIL_PASSWORD=...
