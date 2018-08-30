FROM php:7.0-apache

# Install required tools
RUN apt-get update && apt-get install -y \
    graphviz \
    git && \
    rm -rf /var/lib/apt/lists/*

# Install xhprof
RUN git clone https://github.com/tideways/php-profiler-extension.git /tmp/php-profiler-extension && \
    cd /tmp/php-profiler-extension && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    docker-php-ext-enable tideways_xhprof && \
    rm -rf /tmp/php-profiler-extension

# Install xhprof UI
RUN git clone https://github.com/longxinH/xhprof.git /var/www/xhprof && \
    chown -R www-data:www-data /var/www/xhprof

# Add VHost
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./ports.conf /etc/apache2/ports.conf
