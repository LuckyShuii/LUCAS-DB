# LUCAS|GBD

SGBD project to save time daily without using interfaces I do not like.
This project uses Symfony 7, Vue 3 and diverse libraries

## Run the project

At the moment, this project only runs on MySQL. Using other databases may work but unexpected behavior can occure.

## Start API

`cd api`

`composer install`

change `.env` file, line `DATABASE_URL=` with the proper data of your database

`symfony server:start`

## Start Front

`cd ..`

`cd front`

`npm install`

`npm run dev`
