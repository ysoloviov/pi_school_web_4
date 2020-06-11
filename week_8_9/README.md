## Configuration

All commands should be issued from the root directory, where this file lies in.

### Virtual hosts

```bash

# set ROOT_DIR variable to the project root
vim spa

# set up back and front virtual hosts
sudo mkdir /etc/httpd/conf/hosts
sudo cp spa /etc/httpd/conf/hosts/spa

# make apache to recognize these hosts
sudoedit /etc/httpd/conf/httpd.conf
...
Include conf/hosts/*

# restart apache to apply changes
sudo systemctl restart httpd.service

# configure the hosts file
sudoedit /etc/hosts
...
127.0.0.1 back
127.0.0.1 front
```

### Backend

Database schema and auth data are in `back/schema.sql` and `back/env/database.php`
accordingly.
