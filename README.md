API CommoPrices
===============

Le projet CommoPrices API a été lancé lors du [Sandwich Class Camp] 2 à l'[ETNA] par l'entreprise [CommoPrices].

Celui-ci à pour but de générer un fichier au format [JSON] contenant les informations des marchés des matières premières et autres.

Voici le rendu :
![alt tag](https://raw.githubusercontent.com/perriea/API-CommoPrices/master/Results/GRAPH/CAF%C3%89-PARAM.png)

Installation
------------

### API
Remplacer les fichiers par ceux du Git ([dossier]) et lancer Laravel (`php artisan serve`).

Si vous souhaitez rajouter d'autres choses :
- [Middleware] : `php artisan make:middleware {name}`
- [Controlleur] : `php artisan make:controller {name}`
- [Migration] SQL : `php artisan make:migration {name}`


### Graphiques

Dans le `<head>` de la view **graph** ajouter :
``` html
<link rel="stylesheet" href="/assets/css/style.css" type="text/css">
<script src="/assets/js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/assets/js/amcharts/serial.js" type="text/javascript"></script>
<script src="/assets/js/amcharts/themes/dark.js" type="text/javascript"></script>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/graph.js"></script>
```

[View Laravel] 


Utilisation
-----------

### Ouverture d'une session (auth)

Pour accéder à l'API, vous devez être obligatoirement authentifié, voici la méthode :

`http://localhost:8000/api/auth/{user}/{token}`

[Réponse auth]


### Fermeture d'une session (logout)

Après avoir fait toutes vos demandes vous pouvez fermer votre session :

`http://localhost:8000/api/logout`

[Réponse logout]


### Afficher data (show)

Avec cette méthode vous pouvez afficher les données et filtrer via differents paramètres : 

- **flux** (GET, accessible NC8) : **i** (import) ou **e** (export),
- **country** (GET, accessible NC8) : code [ISO 3166-1],
- **start** & **end** (GET, accessible NC8 & IMF) : date de début et de fin (il n'est pas obligatoire d'utiliser les deux en même temps) au format M-YYYY,
- **lang** (GET, accessible NC8 & IMF) : afficher les données dans la langue de votre choix.

Exemple : `http://localhost:8000/api/show/nc8_18010000?flux=e&country=it&start=1-2014&end=3-2015&lang=fr`

[Réponse show]


### Afficher uniquement les variation (var)

Cette méthode permet d'afficher seulement la variation en pourcent d'une matière dans un interval.

Tous les paramètres peuvent être utilise sauf **start** & **end**.

Un nouveau paramètre est disponible pour la variation : 

- **inter** (GET, accessible NC8 & IMF) : mensuel, trimestriel ou semestriel (m, t ou s) par défaut mensuel,


Pour le paramètre **flux** si l'on ne précise pas le sens, l'**export** sortira par defaut.

Exemple : `http://localhost:8000/api/var/nc8_18010000?country=it&start=1-2014&end=3-2015&lang=fr`

[Réponse var]


Graphiques
----------

Vous pouvez afficher un graphique avec les données de l'API.

Exemple : `http://localhost:8000/graph/{matiere}`


Vous devez inscrire l'utilisateur et le token de l'utilisateur dans `graph.js`.

``` js
var log = "{user}";
    token = "{token}";
    res = 0;
    prix_max = 0;
    prix_min = 9999999999;
    theme = "dark";
```


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
[View Laravel]: https://raw.githubusercontent.com/perriea/API-CommoPrices/master/Results/GRAPH/PALUM-PARAM.png
