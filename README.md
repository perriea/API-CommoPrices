API CommoPrices
===============

Le projet CommoPrices API a été lancé lors du [Sandwich Class Camp] 2 à l'[ETNA] par l'entreprise [CommoPrices].

Celui-ci à pour but de generer un fichier au format JSON contenant les information des marchés des matieres premières et autres.


Installation
------------

Remplacer les fichiers par ceux du Git et lancer [Laravel].

Si vous souhaitez rajouter d'autres choses :
- Middleware : `php artisan make:middleware`
- Controlleur : `php artisan make:controller`
- Migration SQL : `php artisan make:migration`


Utilisation
-----------

### Ouverture d'une session (auth)

Pour acceder à l'API, vous devez être obligatoirement authentifié, voici la méthode :

`http://localhost:8000/api/auth/{user}/{token}`


### Fermeture d'une session (logout)

Après avoir fait toutes vos demandes vous pouvez fermer votre session :

`http://localhost:8000/api/logout`


### Afficher data (show)




### Afficher uniquement les variation (var)





[Sandwich Class Camp]: https://co-labs.etna.io
[ETNA]: http://www.etna-alternance.net
[CommoPrices]: https://commoprices.com/
[Laravel]: http://laravel.com