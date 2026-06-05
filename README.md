Docker Compose para ejecución:

```
services:
  nginx:
    image: nginx:alpine
    ports:
      - 80:80
    volumes:
      - ./gescon-web:/usr/share/nginx/html
      - ./default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - php
  
  php:
    image: php:8.2-fpm
    volumes:
      - ./gescon-web:/usr/share/nginx/html

  api:
    build:
      context: ./gescon-api
    container_name: gescon-api
    ports:
      - "3000:3000"
    volumes:
      - ./gescon-api:/gescon-api
      - /gescon-api/node_modules
    restart: always

  react:
    build:
      context: ./gescon-react
    container_name: gescon-react
    ports:
      - "5173:5173"
    volumes:
      - ./gescon-react:/gescon-react
      - /gescon-react/node_modules
    environment:
      - CHOKIDAR_USEPOLLING=true
    command: npm run dev
    depends_on:
      api:
        condition: service_healthy
```

default.conf:

```
server {
    listen 80;
    server_name localhost;

    root /usr/share/nginx/html;
    index index.php index.html;

    location /api/ {
        proxy_pass http://api:3000/;
        proxy_http_version 1.1;

        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }

    location / {
      try_files $uri $uri.html $uri/ @extensionless-php;
      index index.html index.htm index.php;
    }

    # Reescribe a PHP si existe
    location @php {
        rewrite ^(.+)$ $1.php last;
    }

    # Reescribe a HTML si existe
    location @html {
        rewrite ^(.+)$ $1.html last;
    }

    location ~ \.php$ {
        try_files $uri =404;

        include fastcgi_params;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location @extensionless-php {
      rewrite ^(.*)$ $1.php last;
    }

    error_page 404 /404.php;

    location = /404.php {
        include fastcgi_params;
        fastcgi_pass php:9000;
        fastcgi_index 404.php;
        fastcgi_param SCRIPT_FILENAME $document_root/gescon/404.php;
    }
}
```
