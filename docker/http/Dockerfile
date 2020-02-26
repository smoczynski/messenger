FROM nginx:1.15.0

# INSTALL OPEN SSL
RUN apt-get update && apt-get install -y \
  openssl \
  htop \
  nano \
  iputils-ping \
  curl

# CLEAN APT AND TMP
RUN apt-get clean && apt-get autoremove && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# COPY VHOST DEFINTIONS
COPY conf.d/* /etc/nginx/templates/

# COPY AUTH DATA
COPY .htpasswd /etc/nginx

# pass env variables to .conf files
COPY run-nginx.sh /bin/run-nginx.sh
