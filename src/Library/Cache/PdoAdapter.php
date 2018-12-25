<?php

declare(strict_types=1);

namespace App\Library\Cache;

use App\Library\Db;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\PdoCache;

/**
 * PdoAdapter 缓存适配器
 *
 * Class PdoAdapter
 * @package App\Library\Cache
 */
class PdoAdapter extends PdoCache
{
    /**
     * PdoAdapter constructor.
     *
     * @param ContainerInterface $container
     * @param array              $options
     */
    public function __construct(ContainerInterface $container, array $options)
    {
        $databaseConfig = $container->get('settings')['database'];

        $pdo = $container->get(Db::class)->pdo;
        $namespace = '';
        $defaultLifetime = 0;
        $config = [
            'db_table'        => $databaseConfig['prefix'] . 'cache',
            'db_id_col'       => 'name',
            'db_data_col'     => 'value',
            'db_lifetime_col' => 'life_time',
            'db_time_col'     => 'create_time',
        ];

        parent::__construct($pdo, $namespace, $defaultLifetime, $config);
    }
}