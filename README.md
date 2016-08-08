# Resource Management system

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
sudo cp dev/nginx/resourcemanagement.conf /opt/local/etc/nginx/sites/resourcemanagement.conf

```

```
sudo bash -c 'echo "127.0.0.1   resourcemanagement.dev" >> /etc/hosts'
```