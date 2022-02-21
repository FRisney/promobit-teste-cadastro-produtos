FROM php-fpm as base

# -----------------------------------------------------------
FROM nginx

ENV UNAME=web

RUN apt-get update \
&& apt-get install -y curl vim mc tree jq \
# Cleanup
&& apt-get clean \
&& apt-get autoremove -y --purge

# copy nginx virtual host configuration for the prokect
COPY ./docker/nginx/site.conf /etc/nginx/conf.d/default.conf

WORKDIR /app
RUN mkdir /var/log/app
# copy public directory from the php-fpm docker image loaded here as base
COPY --from=base /app/public /app/public