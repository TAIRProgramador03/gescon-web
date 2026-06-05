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
