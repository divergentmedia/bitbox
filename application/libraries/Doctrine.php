<?php

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager;

class Doctrine
{

    public $em;

    public function __construct()
    {

//        Setup::registerAutoloadDirectory(__DIR__);

        // Load the database configuration from CodeIgniter
        require(APPPATH . 'config/database.php');

        $connection_options = array(
            'driver'        => 'pdo_mysql',
            'user'          => $db['default']['username'],
            'password'      => $db['default']['password'],
            'host'          => $db['default']['hostname'],
            'dbname'        => $db['default']['database'],
            'charset'       => $db['default']['char_set'],
            'driverOptions' => array(
                'charset'   => $db['default']['char_set'],
            ),
        );

        // With this configuration, your model files need to be in application/models/Entity
        // e.g. Creating a new Entity\User loads the class from application/models/Entity/User.php
        $models_namespace = 'Entity';
        $models_path = APPPATH . 'models';
        $proxies_dir = APPPATH . 'models/Proxies';
        $metadata_paths = array(APPPATH . 'doctrine');

        // Set $dev_mode to TRUE to disable caching while you develop
        //$config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode = true, $proxies_dir);
        $config = Setup::createXMLMetadataConfiguration($metadata_paths, $dev_mode = true, $proxies_dir);

        $this->em = EntityManager::create($connection_options, $config);

        $loader = new ClassLoader($models_namespace, $models_path);
        $loader->register();
    }

}
