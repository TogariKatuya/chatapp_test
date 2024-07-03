## 環境構築

<!-- コンテナの作成方法、フレームワークのインストール方法など、開発環境構築に必要な情報を記載 -->

### ルートディレクトリを作成する

    $ mkdir chatapp_test
    $ cd chatapp_test

### docker-compose.ymlファイルを作成して編集する

    $ touch docker-compose.yml

・docker-compose.yml記述内容

    version: '3'
    services:
    db:
        image: mysql:5.7.36
        container_name: "mysql_test"
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: mysql_test_db
            MYSQL_USER: admin
            MYSQL_PASSWORD: secret
            TZ: 'Asia/Tokyo'
        # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
        ports:
            - 3306:3306
        # コマンドの指定
        command: mysqld --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
        # 名前付きボリュームを設定する（名前付きボリューム:コンテナ側ボリュームの場所）
        volumes:
        - db_data_test:/var/lib/mysql
        - db_my.cnf_test:/etc/mysql/conf.d/my.cnf
        - db_sql_test:/docker-entrypoint-initdb.d

    php:
        build: ./docker/php
        container_name: "php-fpm"
        # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
        volumes:
        - ./src:/var/www

    nginx:
        image: nginx:latest
        container_name: "nginx_test"
        # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
        ports:
        - 80:80
        # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
        volumes:
        - ./src:/var/www
        - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
        # サービスの依存関係を指定（nginxをphpに依存させる）
        depends_on:
        - php

    node:
        image: node:14.18-alpine
        container_name: "node14.18-alpine"
        # コンテナ内の標準出力とホストの出力を設定：trueを指定
        tty: true
        # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
        volumes:
        - ./src:/var/www
        # コンテナ起動後のカレントディレクトリを設定
        working_dir: /var/www

    # サービスレベルで名前付きボリュームを命名する
    volumes:
    db_data_test:
    db_my.cnf_test:
    db_sql_test:

### ルートディレクトリ直下に¥docker ¥src を作成する

    $ mkdir docker && mkdir src

### ¥docker 直下に ¥php ¥nginx を作成

    $ cd docker
    $ mkdir php && mkdir nginx

### ¥php 直下に Dockerfile php.ini を作成して編集する

    $ cd php
    $ touch Dockerfile && touch php.ini

### Dockerfile記述内容

    # Dockerimage の指定
    FROM php:8.0-fpm
    COPY php.ini /usr/local/etc/php/

    # Package & Library install
    RUN apt-get update \
        && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
        && docker-php-ext-install zip pdo_mysql

    # Composer install
    RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    RUN php composer-setup.php
    RUN php -r "unlink('composer-setup.php');"
    RUN mv composer.phar /usr/local/bin/composer

    ENV COMPOSER_ALLOW_SUPERUSER 1
    ENV COMPOSER_HOME /composer
    ENV PATH $PATH:/composer/vendor/bin

    # WorkDir Path setting
    WORKDIR /var/www

    # Laravel Package install
    RUN composer global require "laravel/installer"

・php.ini 記述内容

    ; 日付設定
    [Date]
    date.timezone = "Asia/Tokyo"
    ; 文字＆言語設定
    [mbstring]
    mbstring.internal_encoding = "UTF-8"
    mbstring.language = "Japanese"

### ¥nginx 直下に default.conf を作成して編集する

    $ cd ..
    $ cd nginx && touch default.conf

・default.conf 記述内容

    server {
        listen 80;
        index index.php index.html;
        root /var/www/LaravelTestProject/public;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass php:9000;
            fastcgi_index index.php;
            include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_param PATH_INFO $fastcgi_path_info;
        }
    }

### Docker を起動してコンテナを作る

    $ cd .. && cd ..
    $ docker-compose up -d

### コンテナにログインする※ターミナルによっては動かない場合があります！！

    $ docker-compose exec php bash

### Laravelをインストールする

    root@~/www# composer create-project "laravel/laravel=9.*" LaravelTestProject

### インストールの確認をする

    root@~/www# cd LaravelTestProject
    root@~LaravelTestProject # php artisan --version

    Laravel Framework 9.52.15

    # Composerのオートロードを再実行しておく
    root@~LaravelTestProject # composer dump-autoload

### ブラウザでLaravelの表示を確認する

ブラウザに http://localhost/ でアクセスして表示されればOKです。

・権限でのエラーが出た場合

    # PermissionDeniedエラーの対処方法
    root@~LaravelTestProject # chown ./www-data/storage -R

### .env と .env.example の環境設定をする ・.env.example（書き換え箇所）

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=mysql_test_db
    DB_USERNAME=admin
    DB_PASSWORD=secret
        
### 次に .env.example を .env にコピーします。

    # .env.example を .env にコピー
    root@~LaravelReactProject # cp .env.example .env
    # キージェネレートする
    root@~LaravelReactProject # php artisan key:generate

### コンテナからログアウト

    root@~LaravelTestProject # exit
