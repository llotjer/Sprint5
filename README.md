## Nom del Projecte

## API-DICE

### Descripció breu: 

Aplicació Laravel per gestionar el registre d'usuaris i jugadors a una aplicació per a generar partides de daus.

**Requisits previs (assegura't de tenir els següents elements instal·lats abans de començar)** :

[Git](https://git-scm.com/downloads)    
[PHP version 8.2.12](https://www.php.net/downloads.php)   
[Composer version 2.7.7](https://getcomposer.org/download/)      
[Laravel Framework 11.34.2](https://laravel.com/docs/11.x/installation)                  
[Postman for Windows Version 11.22.1](https://www.postman.com/downloads/)     

### Instal·lació

#### Clonar el repositori:

git clone https://github.com/llotjer/Sprint5.git

#### Instal·lar les dependències de PHP:

composer install

#### Edita la base de dades al fitxer .env d'aquesta manera (el fitxer per a l'entorn dels tests ja està al repositori):

DB_CONNECTION=sqlite    
\# DB_HOST=    
\# DB_PORT=    
\# DB_DATABASE=database/database.sqlite    
\# DB_USERNAME=    
\# DB_PASSWORD=    

*Per a la previsualització del arxiu database.sqlite pots utilitzar l'extensió de Visual Studio Code:*

SQLite Viewer (de Florian Klampfer)

#### Instal·lar Laravel Passport:

php artisan passport:install

#### Generar les claus personals de client:

php artisan passport:client --personal

#### Autenticació:

Registra't o autentica't mitjançant les rutes presents a la collecció: **postman_collection.json**

#### Executar el servidor local:

php artisan serve

#### Testing:

php artisan test
