FROM php:8.1.5-zts
FROM composer:2.3.5
WORKDIR /app
COPY . /app
RUN composer install
EXPOSE 8080
CMD [ "php","spark","serve" ]

#docker build -t chipskein/uaibank.0.0.1
#docker run -p 8080:8080 -d chipskein/uaibank:0.0.1