FROM ctftraining/base_image_nginx_mysql_php_73

# 安装必要的软件包
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories  &&\
    apk add --update --no-cache bash



RUN rm -r /var/www/html/index.php && \
    rm -rf /tmp/* && \
    rm -rf /etc/apk 

COPY ./src/ /var/www/html

COPY db.sql /var/db.sql

COPY ./service/docker-entrypoint.sh /docker-entrypoint.sh

RUN sh -c 'mysqld_safe &' \
	&& sleep 5s \
    && mysqladmin -uroot password '123456' \ 
    && mysql -e "source /var/db.sql;" -uroot -p123456 \
    && chmod -R 777 /docker-entrypoint.sh \
    && chmod -R 777 /var/db.sql \
    && chown -R www-data:www-data /var/www/html 

RUN /docker-entrypoint.sh
