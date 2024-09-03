FROM php:8.2-fpm

# 其他配置
# 安装相關依賴套件
RUN apt-get update > /dev/null && apt-get install -y \
   git \
   unzip \
   libjpeg-dev \
   libxpm-dev \
   libwebp-dev \
   libfreetype6-dev \
   libjpeg62-turbo-dev \
   libmcrypt-dev \
   libzip-dev \
   libpng-dev \
   zlib1g-dev \
   libicu-dev \
   jpegoptim \
   g++ \
   libxrender1 \
   libfontconfig


# 安装 PHP zip 擴展
RUN docker-php-ext-install intl > /dev/null \
   && docker-php-ext-install zip > /dev/null \
   && docker-php-ext-install bcmath > /dev/null \
   && docker-php-ext-install pdo pdo_mysql mysqli > /dev/null
