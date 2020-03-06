# Configurar el servidor

## Despliegue en Homestead
Si la nostra màquina és per a desenvolupar l'aplicació el més senzill és crear un entorn amb Vagrant i Homestead. En la [documentació de Laravel](https://laravel.com/docs/5.6/homestead) hi ha informació de còm crear i configurar eixe entorn.

A l'hora de descarregar el codi, creem la carpeta que vaja a contenir el nostre codi i anem a ella:
```bash
mkdir ~/code/borsaBatoi
cd ~/code/borsaBatoi
```

Inicialitzem git i descarregem l'aplicació:
```bash
git init
git remote add origin https://github.com/cipfpbatoi/borsaBatoi.git
git pull origin master
```

Des de **dins de la màquina Homestead** instal·lem les llibreries necessàries (això tardarà prou perquè ha de baixar-se moltes llibreries de Internet):
```bash
composer update
npm install
```
i copiem el fitxer **.env** que no es descarrega de git. Allí hem de configurar:
- APP_NAME: Ponemos nuestro nombre (CIP FP Batoi)
- l'accés a la BBDD (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- el mail: MAIL_DRIVER (sendmail), MAIL_HOST (localhost), MAIL_PORT (25), MAIL_USERNAME (usuario del sistema que envía los e-mails), MAIL_PASSWORD (su contrasenña), MAIL_ ENCRYPTION (null), MAIL_FROM_ADDRESS (borsatreball@cipfpbatoi.es), MAIL_FROM_NAME ("Borsa Treball Batoi")
- 

Creem la BBDD `borsatreball` i executem la migración:
```bash
php artisan migrate
php artisan db:seed
```

Hem de donar permisos d'escriptura a l'usuari www-data sobre la carpeta storage i el seu contingut.

Per a l'autenticació hdem d'instal·lar [laravel/passport](https://laravel.com/docs/5.8/passport). A continuació executem el comando `passport:install` que crea las claus d'encriptació que s'utilitzen per a generar els tokens. A més crea els clients "personal access" i "password grant" clients which will be used to generate access tokens):
```bash
php artisan passport:install
```

## Configurar el mail
Nosaltres hem instal·lat **`postmail`** i hem creat en el sistema l'usuari `usrmail` per a enviar els correus. EN el **`.env`** configurem:
```bash
MAIL_DRIVER=sendmail
MAIL_HOST=localhost
MAIL_PORT=25
MAIL_USERNAME=usrmail
MAIL_PASSWORD=P@ssW0rd
MAIL_ENCRYPTION=null
MAIL_FROM_NAME="Borsa Treball Batoi"
MAIL_FROM_ADDRESS=borsa@nosaltres.com
```

Permisos de www-data a storage. Configurar mail en .env

## Cosas raras
1. Cada vez que te cargas la bbd hay que ejecutar `php artisan passport:client --personal`
