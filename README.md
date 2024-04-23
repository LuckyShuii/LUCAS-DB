# LUCAS|DB

[![Symfony](https://img.shields.io/badge/Symfony-071663?logo=symfony)](https://symfony.com/)
[![VueJS](https://img.shields.io/badge/Vue.js-4FC08D?logo=vue.js&logoColor=white)](https://vuejs.org/)

Databases administration project to save time daily without using interfaces I do not like.
This project uses Symfony 7, Vue 3 and diverse libraries

## Run the project

At the moment, this project only runs on MySQL. Using other databases may work but unexpected behavior can occure.

## Start API

`cd api`

`composer install` : only the first time you run the project

change `.env` file, line `DATABASE_URL=` with the proper data of your database (in order to get the login info to run queries)

`symfony console d:d:c`

`symfony server:start`

## Start Front

`cd front`

`npm install` : only the first time you run the project

`npm run dev`

## Preview

![Query TAB](https://media.discordapp.net/attachments/1184761532693884960/1229889282236219463/image.png?ex=663152a7&is=661edda7&hm=4fcb1cbb2088bf3264a6af8f88cbc712f7e5459ab28090c1b133faec7af28a26&=&format=webp&quality=lossless&width=2566&height=1244)