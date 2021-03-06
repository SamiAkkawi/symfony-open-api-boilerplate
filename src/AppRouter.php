<?php declare(strict_types=1);

namespace App;

use App\ApiV1Bundle\SpecificationController as V1SpecsController;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

final class AppRouter extends Loader
{
    private V1SpecsController $v1SpecificationsController;
    private static bool $loadedConfig = false;

    public function __construct(V1SpecsController $v1SpecificationsController)
    {
        $this->v1SpecificationsController = $v1SpecificationsController;
    }

    public function load($resource, string $type = null)
    {
        $routes = new RouteCollection();

        if (!self::$loadedConfig) {
            $routes->addCollection(
                $this->import($this->getConfigDir() . '/routes.yaml')
            );
            if ($_ENV['APP_ENV'] === 'dev') {
                $routes->addCollection(
                    $this->import($this->getConfigDir() . '/routes/dev/web_profiler.yaml')
                );
                $routes->addCollection(
                    $this->import($this->getConfigDir() . '/routes/dev/framework.yaml')
                );
            }
            $routes->addCollection(
                $this->v1SpecificationsController->getApiSpecification()->toSymfonyRouteCollection('handle')
            );
            self::$loadedConfig = true;
        }

        return $routes;
    }

    public function supports($resource, string $type = null)
    {
        if (
            strpos($resource, 'config') !== false
            || strpos($resource, 'xml') !== false
        ) {
            return false;
        }

        return true;
    }

    private function getProjectDir(): string
    {
        return dirname(__DIR__);
    }

    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }
}