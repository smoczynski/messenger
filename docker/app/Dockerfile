FROM codibly/php:7.4

# INSTALL UTILS
RUN apt-get update && apt-get install -y \
  git \
  htop \
  nano \
  iputils-ping \
  curl \
  cron \
  sudo \
  passwd \
  iproute2 \
  librabbitmq-dev \
  supervisor \
  procps \
  && apt-get clean && apt-get autoremove && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# COPY POOL CONFIGURATION
COPY conf.d/pool.conf /usr/local/etc/php-fpm.d/app.conf

# setup supervisor services configuration
COPY conf.d/supervisor-services.conf /etc/supervisor/conf.d/services.conf

# INSTALL XDEBUG AND ADD FUNCTIONS TO TURN ON/OFF XDEBUG
COPY xoff.sh /usr/bin/xoff
COPY xon.sh /usr/bin/xon

RUN set -x \
    && chmod +x /usr/bin/xoff \
    && chmod +x /usr/bin/xon \
    && echo 'PS1="[\$(test -e /usr/local/etc/php/conf.d/xdebug.off && echo XOFF || echo XON)] $HC$FYEL[ $FBLE${debian_chroot:+($debian_chroot)}\u$FYEL: $FBLE\w $FYEL]\\$ $RS"' | tee /etc/bash.bashrc /etc/skel/.bashrc;

#  TWEAK PHP CONFIG
RUN set -x \
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini \
    && sed -i "s|;error_log = log/php-fpm.log|error_log = /proc/self/fd/2|" /usr/local/etc/php-fpm.conf \
    && sed -i "s|memory_limit.*|memory_limit = 2048M|" $PHP_INI_DIR/php.ini \
    && sed -i "s|max_execution_time.*|max_execution_time = 3000|" $PHP_INI_DIR/php.ini \
    && sed -i "s|upload_max_filesize.*|upload_max_filesize = 32M|" $PHP_INI_DIR/php.ini \
    && sed -i "s|post_max_size.*|post_max_size = 48M|" $PHP_INI_DIR/php.ini \
    && sed -i "s|;date.timezone = *|date.timezone = Europe/London|" $PHP_INI_DIR/php.ini \
    && cp $PHP_INI_DIR/php.ini $PHP_INI_DIR/php-cli.ini

# useful for Symfony
RUN set -x \
   && bash -c 'echo "alias sf=bin/console" >> ~/.bashrc'

# INSTALL REDIS EXTENSION
RUN printf "\n" | pecl install redis && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

# INSTALL AMQP EXTENSION
RUN pecl channel-update pecl.php.net
RUN pecl install amqp
RUN echo extension=amqp.so > /usr/local/etc/php/conf.d/amqp.ini

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

# START PHP-FPM
CMD ["php-fpm"]
