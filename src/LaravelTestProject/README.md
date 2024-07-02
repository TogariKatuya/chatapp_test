<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


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

    phpmyadmin:
        image: phpmyadmin/phpmyadmin:latest
        container_name: "phpmyadmin_test"
        environment:
        - PMA_ARBITRARY=1 # サーバ設定：サーバーをローカル以外も指定
        - PMA_HOST=db # ホスト設定：dbを指定
        - PMA_USER=admin # 初期ユーザー設定：adminを指定
        - PMA_PASSWORD=secret # 初期PW設定：secretを指定
        # db（サービス名）とのリンクを設定する
        links:
        - db
        # ポートフォワードの指定（ホスト側ポート：コンテナ側ポート）
        ports:
        - 8080:80
        # ボリュームを設定する（ホスト側ディレクトリ:コンテナ側ボリュームの場所）
        volumes:
        - ./phpmyadmin/sessions:/sessions

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
