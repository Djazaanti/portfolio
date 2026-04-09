# PROJET 5 : MON PREMIER BLOG EN PHP

    Ce projet de formation, c'est ma premère application en PHP natif incluant MVC, TWIG, Flexbox et Bootstrap et MySQL. J'ai crée mes librairies, géré le routage avec les Controllers sans recours aux Bundles afin de mieux comprendre le processus de développement. C'est un projet qui m'a mise en rude épreuve, avec son lot de défis. C'était très passionnant de découvrir d'autres petites fonctions PHP à fort impact dans le routage, comprendre la profondeur du processus MVC et l'optimisation des ressources avec TWIG, etc.  Il reste encore des améliorations à faire pour le mettre au goût du jour, et j'ai hâte de les réaliser bientôt.
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
