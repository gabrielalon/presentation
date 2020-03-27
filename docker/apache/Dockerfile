ARG APACHE_VERSION=""
FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}}

RUN apt-get update && apt-get install -y

RUN rm -rf /var/lib/apt/lists/*

# Copy apache vhost file to proxy php requests to php-fpm container
COPY presentation.apache.conf /usr/local/apache2/conf/presentation.apache.conf
# Add custom Apache config file
ADD presentation.apache.conf /etc/apache2/sites-available/presentation.apache.conf
RUN echo "Include /usr/local/apache2/conf/presentation.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf

WORKDIR /var/www/html/
