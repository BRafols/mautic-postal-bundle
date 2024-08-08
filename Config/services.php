<?php

declare(strict_types=1);

use Mautic\CoreBundle\DependencyInjection\MauticCoreExtension;
use MauticPlugin\PostalBundle\Mailer\Factory\SparkpostTransportFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $excludes = [
        '{Config,Helper/SparkpostResponse.php,Mailer/Transport/SparkpostTransport.php}'
    ];
    $services->load('MauticPlugin\\PostalBundle\\', '../')
        ->exclude('../{'.implode(',', array_merge(MauticCoreExtension::DEFAULT_EXCLUDES, $excludes)).'}');

    $services->get(SparkpostTransportFactory::class)->tag('mailer.transport_factory');
};
