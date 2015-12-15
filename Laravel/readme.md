# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## Routes

### Middleware & Kernel

Un nouveau middleware a été ajouté `midAPI.php` => [Lien Middleware API]

Celui-ci a été declaré dans les Kernel => [Lien Kernel API]

Celui ci permet de reguler l'accès à l'API (auth ou non) dans les routes.


## Views

### API

Un rendu en JSON => [JSON]


### Graphique

Voici le rendu :
![alt tag](https://github.com/perriea/API-CommoPrices/blob/master/Results/GRAPH/CAF%C9.png)


[Lien Middleware API]: https://github.com/perriea/API-CommoPrices/blob/master/Laravel/app/Http/Middleware/midAPI.php
[Lien Kernel API]: https://github.com/perriea/API-CommoPrices/blob/master/Laravel/app/Http/Kernel.php
[JSON]: https://github.com/perriea/API-CommoPrices/blob/master/Results/JSON/Show/reponse.json