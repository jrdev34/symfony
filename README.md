Installation

git clone https://github.com/jrdev34/portfolio.git

cd portfolio

Créeer un fichier .en.local


DATABASE_URL=mysql://root:password@127.0.0.1:3306/portfolio?serverVersion=mariadb-10.4.24charset=utf8mb4"


MAILER_DSN=


ajouter le mailer pour envoyer des mails


https://symfony.com/doc/current/mailer.html



debugg mail php bin/console messenger:consume async

composer install

npm install

composer prepare

Configuration



installer le bundle Api pour créer une api

Démarer le serveur

symfony serve


npm run dev

