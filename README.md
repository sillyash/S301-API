# S301-API

## Project tree

```
root/
│
├── api/
│   ├── api.php
│   ├── db.php
│   ├── Router.php
│   └── send_email.php
│
├── .htaccess
├── api.sh
├── config.php
├── index.php
├── LICENSE
└── README.md
```

## API

### Routes

The routes are defined in the [api.php](./api/api.php) file.

The routes are all displayed in the [index page](https://projets.iut-orsay.fr/prj-mmorich/S301-API), and are all accessible through the [api.php](./api/api.php) file.


## Automatic requests routing

The routing is done with the [Router class](./api/Router.php) : it stores all the possible requests in an array and the function to call for each request.

To add a route, we simply use the `addRoute` method.

Thanks to the config file [htaccess](./.htaccess), all requests to this website gets redirected to the [index](index.php) file (only the request, but the URL stays the same), which simply calls the router on the asked route.

The router then dispatchs the route, or returns a 404 error, depending if the route exists or not.


## Database connection

The connection and PDO management is done through the [Database class](./api/db.php).


## Sending emails

The email sending is done through the [send_email](./api/send_email.php) function, which uses the PHP `mail` function.
