FROM php:8.3-apache

# Install dependencies, unzip, git, curl etc.
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other setup like enabling apache mods, copying files etc.
COPY . /var/www/html

WORKDIR /var/www/html

