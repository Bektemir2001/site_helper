<?php

namespace App\Providers;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('ElasticsearchClient', function () {
            return ClientBuilder::create()
                ->setHosts(['https://localhost:9200']) // Используйте HTTPS
                ->setBasicAuthentication('elastic', 'IwS-OGxXQacBnpJikI3q') // Добавление базовой аутентификации
                ->setSSLVerification(false) // Отключение проверки SSL, используйте только для разработки!
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
