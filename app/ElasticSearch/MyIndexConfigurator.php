<?php

namespace App\ElasticSearch;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class MyIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    protected $name = 'my_index';

    // Здесь могут быть настройки, такие как репликации или шарды
}
