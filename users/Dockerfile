FROM mileschou/phalcon:7.2-alpine
RUN docker-phalcon-install-devtools
RUN mkdir -p /app
#COPY . /app
WORKDIR /app
#RUN ["/usr/src/phalcon-devtools/phalcon",  "migration", "run",  "--log-in-db"]
CMD ["php", "-S", "0.0.0.0:80", "-t", "public", ".htrouter.php"]
#CMD /usr/src/phalcon-devtools/phalcon migration run--log-in-db && \
#    php -S 0.0.0.0:80 -t public .htrouter.php
