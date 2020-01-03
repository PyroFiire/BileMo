BileMo
=====================

Projet 7 du parcours PHP / Symfony sur OpenClassrooms - Créez un web service exposant une API

INSTRUCTION
-----------

GIT AND COMPOSER
--------------------
use "git clone https://github.com/PyroFiire/BileMo.git" in a folder in your server or local for download the project.
use "cd SnowTricks" for go in the project
use "composer install" for install dependancy

CONFIG.PHP
----------

Copie the file .env by .env.local and define your connection to the database (line 28)

Change APP_ENV=dev line 17 for APP_ENV=prod (line 17)

Create your private and public keys JWT in config/jwt/ (with OpenSSL for example)

In .env.local , change the JWT_PASSPHRASE if needed (line 34)


FIXTURES
--------

use "php bin/console doctrine:fixtures:load --group products" for start the project with 11 products and a admin account. Notice : You need developpement environnement for use this commande.
you can load more fixtures for developpement with --group test.

ACCOUNTS
--------

admin connection :
username : admin
password : password