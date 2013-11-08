<?php


define('APPPATH', dirname(__FILE__) . '/application/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development');



require_once("application/libraries/Doctrine.php");
require_once("vendor/autoload.php");
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

foreach ($GLOBALS as $helperSetCandidate) {
    if ($helperSetCandidate instanceof \Symfony\Component\Console\Helper\HelperSet) {
        $helperSet = $helperSetCandidate;
        break;
    }
}

$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
