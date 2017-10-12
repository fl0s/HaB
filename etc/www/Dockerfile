FROM php:7.0-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libxrender1 \
    libfontconfig1 \
    libxext6 \
    xz-utils \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath intl

RUN curl -f https://downloads.wkhtmltopdf.org/0.12/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz -o /root/wkhtmltox.tar.xz
RUN cd /root/ && tar -xJvf wkhtmltox.tar.xz && mv /root/wkhtmltox/bin/wkhtmltopdf /usr/local/bin/
RUN rm -f /root/wkhtmltox.tar.xz && rm -rf /root/wkhtmltox/

RUN sed -e 's%www-data:x:33%www-data:x:1000%g' /etc/passwd -i

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
