# SAE-php

réalisé par Clermont Shanka, Richard Baptiste, Chaloine Tristan et Renaudin Clément

Cette SAE est un site de restaurants, il implemente l'utilisation de la nouvelle API google places (changée très récemment) afin de récupérer les images et d'améliorer la qualité générale du site

## VIDEO PRESENTATION

[Regarder la vidéo](https://youtu.be/-umx_Hcdf18)
"https://youtu.be/-umx_Hcdf18"

## INSTALLATION

Pour utiliser notre site web "My little food", il faut s'assurer d'avoir PHP 8.x et d'activer les differentes extensions dans son .ini
- pdo_pgsql
- php_openssl

Afin de profiter pleinement du il faut disposer du fichier "keys.csv" contenant la clé d'API google et la mettre dans le dossier src/data
(le fichier est normalement fourni avec le rendu car non disponible sur github, si jamais vous en avait un problème avec merci de contacter CLERMONT SHANKA)

Assurez vous d'être sur une connexion ne bloquant pas l'accès à SUPABASE avant de lancer le serveur

Ensuite vous pouvez lancer un serveur php local avec la commande suivante (index.php se trouvant en haut de l'arborescance):
- php -S localhost:8000 index.php


## Fonctionnalitées implémentées

- Affichage des meilleurs restaurants et les plus prisés sur la page d'acceuil
- Possibilité d'inscription au site
- Implementation de l'API google avec des cartes embed et la récupération des données places et photos (images des restaurants)
- Visionage d'un restaurant en détail ainsi que les avis déposés
- Possibilité de déposer un avis et de mettre un restaurant en favoris
- Page d'information personnelle pour y gérer les cuisines et restaurants favoris ainsi que de gérer ses avis déposés
- Fonctionnalité de recherche basique par nom (recherche avancée non implémentée)
