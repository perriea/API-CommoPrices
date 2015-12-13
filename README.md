API CommoPrices
===============

Le projet CommoPrices API a été lancé lors du [Sandwich Class Camp] 2 à l'[ETNA] par l'entreprise [CommoPrices].

Celui-ci à pour but de générer un fichier au format [JSON] contenant les informations des marchés des matières premières et autres.


Installation
------------

Remplacer les fichiers par ceux du Git ([dossier]) et lancer [Laravel] (`php artisan serve`).

Si vous souhaitez rajouter d'autres choses :
- [Middleware] : `php artisan make:middleware`
- [Controlleur] : `php artisan make:controller`
- [Migration] SQL : `php artisan make:migration`


Utilisation
-----------

### Ouverture d'une session (auth)

Pour acceder à l'API, vous devez être obligatoirement authentifié, voici la méthode :

`http://localhost:8000/api/auth/{user}/{token}`

[Réponse auth]


### Fermeture d'une session (logout)

Après avoir fait toutes vos demandes vous pouvez fermer votre session :

`http://localhost:8000/api/logout`

[Réponse logout]


### Afficher data (show)

Avec cette methode vous pouvez afficher les données et filtrer via differents paramètres : 

- **flux** (GET, accessible NC8) : **i** (import) ou **e** (export),
- **country** (GET, accessible NC8) : code [ISO 3166-1],
- **start** & **end** (GET, accessible NC8 & IMF) : date de debut et de fin (il n'est pas obligatoire d'utiliser les deux en meme temps) au format M-YYYY,
- **inter** (GET, accessible NC8 & IMF) :
- **lang** (GET, accessible NC8 & IMF) : afficher les données dans la langue de votre choix.

Exemple : `http://localhost:8000/api/show/nc8_18010000?flux=e&country=it&start=1-2014&end=3-2015&lang=fr`

[Réponse show]


### Afficher uniquement les variation (var)

Cette méthode permet d'afficher seulement la variation en pourcent d'une matiere dans un interval.

Exemple : `http://localhost:8000/api/var/nc8_18010000?country=it&start=1-2014&end=3-2015&lang=fr`

[Réponse var]


Resources
---------

- [PHP 5]
- [MYSQL]
- [Composer] (optionnel)
- [Laravel]


Thanks
------

**API CommoPrices** © 2015, PERRIER Aurélien, MARTINELLI Sébastien & LEON Vincent 

Released under the [MIT License].

> GitHub [@perriea](https://github.com/perriea) &nbsp;&middot;&nbsp;
> GitHub [@cenevol](https://github.com/cenevol) &nbsp;&middot;&nbsp;
> GitHub [@Vincent--L](https://github.com/Vincent--L)



[Sandwich Class Camp]: https://co-labs.etna.io
[ETNA]: http://www.etna-alternance.net
[CommoPrices]: https://commoprices.com/
[Middleware]: http://laravel.com/docs/5.1/middleware
[Controlleur]: http://laravel.com/docs/5.1/controllers
[Migration]: http://laravel.com/docs/5.1/migrations
[Laravel]: http://laravel.com
[dossier]: https://github.com/perriea/API-CommoPrices/tree/master/Laravel
[ISO 3166-1]: http://www.iso.org/iso/fr/french_country_names_and_code_elements
[MIT License]: http://mit-license.org/
[Réponse auth]: https://github.com/perriea/API-CommoPrices/blob/master/Results/JSON/Auth/ok.json
[Réponse logout]: https://github.com/perriea/API-CommoPrices/blob/master/Results/JSON/Auth/fail.json
[Réponse show]: https://github.com/perriea/API-CommoPrices/blob/master/Results/JSON/Show/reponse.json
[Réponse var]: https://github.com/perriea/API-CommoPrices/blob/master/Results/JSON/Var/reponse.json
[PHP 5]: http://php.net
[MYSQL]: https://www.mysql.fr
[JSON]: http://www.json.org