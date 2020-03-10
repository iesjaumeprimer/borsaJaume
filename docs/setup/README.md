# Configurar el servidor

## Desplegament per a desenvolupament
Si la nostra màquina és per a desenvolupar l'aplicació el més senzill és crear un entorn amb Vagrant i **Homestead**. En la [documentació de Laravel](https://laravel.com/docs/5.6/homestead) hi ha informació de còm crear i configurar eixe entorn.

### Descàrrega de l'aplicació
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

## Desplegament per a producció
Si només volem tindre l'aplicació funcionant necessitem un servidor on instal·larem:
* **apache2**
* **mysql-server** o **mariadb-server** (recorda que després hem d'executar el comando **`mysql_secure_installation`** que configura l'usuari root). NOTA: ara la validació dels usuaris la fa el sistema (el _plugin_ 'auth_socket' o 'unix_socket'). Per a configurar un usuari amb privilegis consulta [StackOverflow](https://stackoverflow.com/questions/39281594/error-1698-28000-access-denied-for-user-rootlocalhost) o qualsevol altra pàgina en internet. En resum, executem:
```bash
mysql_secure_installation
sudo mysql -u root

mysql> USE mysql;
mysql> SELECT User, Host, plugin, authentication_string FROM mysql.user;
### Si uso Mysql li canvie el plugin i li pose una contrasenya, en equest exemple P@ssw0rd
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'P@ssw0rd';
### Si use MariaDB execute els 2 comandos següents per a canviar el password a l'usuari. Amb Mysql no cal
mysql> UPDATE user SET password=PASSWORD('your_p@ssw0rd') WHERE User='root';
mysql> UPDATE user SET plugin='auth_socket' WHERE User='root';
### I per últim, tant en MariaDB com en Mysql, execute
mysql> FLUSH PRIVILEGES;
mysql> exit;

sudo systemctl restart mysql.service    # o mariadb.service
```
Fuente correcta para mysql:[How To Install MySQL on Ubuntu 18.04](https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-18-04#step-2-%E2%80%94-configuring-mysql)

Ara ja hauria de poder accedir a la BBDD a traves de Phpmyadmin. Continue instal·lant paquests:

* **php**
* **phpmyadmin**
* **git**
* **composer**

### Configurar apache
Creem els certificats (el _.key_ en /etc/ssl/private i els altres 2 en en /etc/ssl/certs):
```bash
openssl genrsa -out borsa.key 1024
openssl req -new -key ../private/borsa.key -out borsa.csr   # completem la informació que ens demanen
openssl x509 -req -in borsa.csr -signkey ../private/borsa.key -out borsa.crt
```

Posem en /etc/hosts el nom de la màquina (p.ej. `intranet.my`).

Configurem el lloc web SSL en _/etc/apache2/sites-available_:
* ServerName: p.ej. `ServerName borsa.my`
* DocumentRoot: `DocumentRoot /var/www/html/borsaBatoi/public`
* SSLCertificateFile: `SSLCertificateFile /etc/ssl/certs/borsa.crt`
* SSLCertificateKeyFile: `SSLCertificateKeyFile /etc/ssl/private/borsa.key`
* Creem un nou directori:`
```bash
<Directory /var/www/html/borsaBatoi/public>
  AllowOverride All
  Order Allow,Deny
  Allow from All
</Directory>
```

Configurem el lloc web no SSL en _/etc/apache2/sites-available_ per a que redireccione al SSL:
* ServerName: p.ej. `ServerName borsa.my`
* Redireccionem: `Redirect permanent  /  https://borsa.my/`
* DocumentRoot: `DocumentRoot /var/www/html/borsaBatoi/public`

Habilitem els sites si els hem creat nous:
```bash
sudo a2ensite borsa.conf
sudo a2ensite borsa-ssl.conf
```

Posem el nostre domini en el **/etc/hosts**:
```bash
127.0.0.1   borsa.my
```

Ara descarreguem l'aplicació des de Github:
```bash
mkdir /var/www/html/borsaBatoi
cd /var/www/html/borsaBatoi
git init
git remote add origin https://github.com/cipfpbatoi/borsaBatoi.git
git pull origin master
```

Per a finalitzar hem d'activar (si no ho estan ja) els mòduls **ssl** i **rewrite** i reiniciar apache:
```bash
sudo a2enmod ssl
sudo a2enmod rewrite
sudo systemctl restart apache2.service
```
ATENCIÓ: cal que estiga la carpeta borsaBatoi ja creada abans de reiniciar Apache per que no done un error.

## Configuració de l'aplicació
Des de la carpeta on tenim l'apliocació descarregada instal·lem les llibreries necessàries (això tardarà prou perquè ha de baixar-se moltes llibreries de Internet):
```bash
composer update
npm install # aquest comando no cal fer-ho en producció
```

Copiem el fitxer **.env**, que no es descarrega de git, des de **.env-example**. Allí hem de configurar:
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
Nosaltres hem instal·lat **`postmail`** i hem creat en el sistema l'usuari `usrmail` per a enviar els correus. En el fitxer **`.env`** configurem:
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

Si has de tornar a crear la base de dades hauras d'executar `php artisan passport:client --personal` per a que es tornen a generar les taules que utilitza _passport_ per a autenticar als usuaris.

