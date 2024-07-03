<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\GoogleBooksRepository;
use App\Services\BookService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * サービスを登録します。
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookRepositoryInterface::class, GoogleBooksRepository::class);
        $this->app->bind(BookService::class, function ($app) {
            return new BookService($app->make(BookRepositoryInterface::class));
        });
    }

}
