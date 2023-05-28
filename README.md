# App test Plus Que Pro

- [Notes](#notes)
- [Technologies](#technologies)
- [Installation](#installation)

## Notes
Je n'ai pas utilisé Laravel Sail, je ne connais pas et je n'utilise pas Docker.
Configuration de mon environnement de développement :
- wampserver 3.1.1
- php 8.1.19
- MySQL 8.0.33
- PhpMyAdmin 5.2.1
- node 16.16.0
- apache 2.4.39

## Technologies
Back
- Laravel 9.52.7
- Guzzle Http 7.7
- laravel/ui 4.2

Front
- vue 3.2.37
- vite 4.0.0
- vue-router 4.2.1
- moment 2.29.4
- vue-sweetalert2 5.0.5 ()
- primevue 3.29.1
- vueform multiselect 2.6.2
- vue3-notification 2.9.1
- axios 1.1.2
- bootstrap 5.2.3

## Installation

1) Ouvrir une console et lancer un git clone pour récupérer le code
2) Ouvrir une console à la racine de votre projet puis lancer la commande composer install
3) Renommer votre .env.example en .env
4) Créer une base de données vide, puis saisir le nom de celle-ci dans votre .env, ainsi que le username et le mot de passe de votre base de données :
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_BDD
DB_USERNAME=nom_de_votre_BDD_user
DB_PASSWORD=password_de_votre_BDD
```
5) Pour générer la base de données, saisir la commande suivante :
```sh
php artisan migrate
```
6) Dans la console, lancer la commande suivante :
```sh
npm install
```

7) Pour générer le front :
- Soit ouvrir une console, puis saisir la commande npm run dev
- Soit configurer "ASSET_URL" dans votre .env, en indiquant le chemin (public) de votre application (exemple : http://localhost/testPlusQuePro/public), puis lancer la commande npm run build

8) Pour récupérer les données depuis l'API https://api.themoviedb.org/3, ouvrir une console à la racine de votre projet puis lancer la commande suivante :
```sh
php artisan command:import_films
```
9) Ouvrir votre navigateur puis se rendre à l'adresse de votre application (exemple : http://localhost/plusQuePro/public/login)

10) Pour se connecter :
- Adresse Mail : user@user.fr
- Mot de passe : user123456