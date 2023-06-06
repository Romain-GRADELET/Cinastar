# E02 : création du projet

## création du projet symfony avec composer
composer create-project symfony/skeleton:"^5.4" my_project_directory

## déplacement des fichiers à la racine
mv ./my_project_directory/* ./my_project_directory/.* .

## suppression du dossier temporaire
rmdir ./my_project_directory

## installation du webapp
composer require webapp

