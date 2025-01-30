# S301-API

## Project tree

```dir
.
├── api
│   ├── api.php
│   ├── db.php
│   ├── delete_routes.php
│   ├── get_routes.php
│   ├── Mail.php
│   ├── post_routes.php
│   ├── put_routes.php
│   └── Router.php
├── models
│   ├── A_pour_reaction.php
│   ├── A_pour_theme.php
│   ├── Budget.php
│   ├── Commentaire.php
│   ├── Concerne_la_notification.php
│   ├── Est_envoye_au_membre.php
│   ├── Fait_partie_de.php
│   ├── Groupe.php
│   ├── Internaute.php
│   ├── Modele.php
│   ├── Notification.php
│   ├── Propose.php
│   ├── Proposition.php
│   ├── Reaction.php
│   ├── Reagit.php
│   ├── Role.php
│   ├── Scrutin.php
│   ├── Signalement.php
│   ├── Theme.php
│   └── Vote.php
├── .htaccess
├── config.php
├── index.php
├── LICENSE
├── README.md
└── ROUTES.md
```

## API

### Routes

The routes are defined in the [api.php](./api/api.php) file.

The routes are all displayed in the [index page](https://projets.iut-orsay.fr/prj-mmorich/S301-API).

#### See all the routes [here](./ROUTES.md).

### Automatic requests routing

The routing is done with the [Router class](./api/Router.php) : it stores all the possible requests in an array and the function to call for each request.

To add a route, we simply use the `addRoute` method.

Thanks to the config file [htaccess](./.htaccess), all requests to this website gets redirected to the [index](index.php) file (only the request, but the URL stays the same), which simply calls the router on the asked route.

The router then dispatchs the route, or returns a 404 error, depending if the route exists or not.


## Database connection

The connection and PDO management is done through the [Database class](./api/db.php).
