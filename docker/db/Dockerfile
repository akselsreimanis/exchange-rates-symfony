FROM postgres:13.3-alpine

## Set timezone
RUN apk add --no-cache tzdata && \
    cp /usr/share/zoneinfo/Europe/Riga /etc/localtime