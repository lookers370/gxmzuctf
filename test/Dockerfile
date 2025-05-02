FROM ctftraining/base_image_nginx_mysql_php_73

# 安装必要的软件包
RUN sed -i \
    -e 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' \
    -e 's/#\(.*community\)/\1/' \
    /etc/apk/repositories && \
    apk update && \
    apk add --no-cache \
    gcc \
    bash  \
    sudo \
    shadow && \
    # 安装后立即清理缓存
    rm -rf /var/cache/apk/*

#创建lookers用户
RUN adduser -D -h /home/lookers -s /bin/bash  lookers 
RUN echo 'lookers:admin123' | chpasswd
RUN chmod 4755 /bin/su

RUN echo 'lookers ALL=(root) NOPASSWD: /usr/bin/gcc' > /etc/sudoers.d/lookers && \
    chmod 0440 /etc/sudoers.d/lookers

# 修改 www-data 用户的 Shell 为 /bin/bash
RUN sed -i 's|^www-data:\(.*\):/sbin/nologin$|www-data:\1:/bin/bash|' /etc/passwd

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
