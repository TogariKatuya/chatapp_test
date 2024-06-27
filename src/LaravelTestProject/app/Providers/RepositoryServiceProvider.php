<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\GoogleBooksRepository;

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
    }

}
