FROM mileschou/phalcon:7.2-alpine
RUN docker-phalcon-install-devtools
RUN mkdir -p /app
#COPY . /app
WORKDIR /app
CMD ["php", "-S", "0.0.0.0:80", "-t", "public", ".htrouter.php"]
EXPOSE 80
