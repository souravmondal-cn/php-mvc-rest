# A sample PHP MVC based Application on the base of Silex framework

## Installation guide

### Run the following commands from project root
```
composer install
make local-settings
```

### For generating database tables run the following
```
make migrate
```

### Nginx server setup
```
Change the root to your project directory.
sudo cp dev/nginx/sample-rest-api.conf /Path to Nginx/nginx/sites/sample-rest-api.conf

```

Do the changes you for nginx config file.

Add the virtual host to the system hosts file.

```
sudo bash -c 'echo "127.0.0.1   samplephpapp.dev" >> /etc/hosts'
```

