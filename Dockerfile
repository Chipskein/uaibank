FROM php:8.1.5-zts
FROM composer:2.3.5
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions intl mbstring json xml mysqli
WORKDIR /app
COPY . /app
RUN composer install
EXPOSE 8080

CMD [ "php","spark","serve" ]

#docker build -t chipskein/uaibank
#docker run -p 8080:8080 -d chipskein/uaibank