deploiement 

dans notre dosiier de projet se connecter a heroku 

avec la commande heroku login accepter sur le naviagteur 

ensuite faire 

git init

git add .

git commit -m "initial import"

heroku create

heroku config:set APP_ENV=prod

pour la base de donner j'ai utiliser cleardb 
j'ai rentrer la DATABASE_URL en lien avec cela 
pour ma page conatct j'ai installer l'addon mailtrap j'ai rentrer le mailer dns qui va avec 

pour que les mails passe j'ai lancer cette commande 

heroku run  php bin/console messenger:consume async




dans composer.json 

j'ai mis un script 

"compile": [
            "php bin/console doctrine:schema:update -f",
            "php bin/console doctrine:fixtures:load --no-interaction --env=PROD"
]



git push heroku master

ensuite creer un fichier nginx_app.conf


location / {
    # try to serve file directly, fallback to rewrite
    try_files $uri @rewriteapp;
}

location @rewriteapp {
    # rewrite all to index.php
    rewrite ^(.*)$ /index.php/$1 last;
}

location ~ ^/index\.php(/|$) {
    try_files @heroku-fcgi @heroku-fcgi;
    # ensure that /index.php isn't accessible directly, but only through a rewrite
    internal;
}
puis faire cela 


echo 'web: heroku-php-nginx -C nginx_app.conf public/' > Procfile

git add Procfile nginx_app.conf

git commit -m "Nginx Procfile and config"

git push heroku master 

git push origin master 

appres j'ai fait un heroku open 

