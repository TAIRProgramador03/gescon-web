FROM nginx:alpine

# Elimina config default (opcional)
RUN rm -rf /usr/share/nginx/html/*

# Copia tu frontend
COPY . /usr/share/nginx/html

# Puerto
EXPOSE 80