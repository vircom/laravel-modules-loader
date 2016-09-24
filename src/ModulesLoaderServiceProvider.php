<?php

namespace VirCom\Laravel\ModulesLoader;

use Illuminate\Support\ServiceProvider;

use VirCom\Laravel\ModulesLoader\Exceptions\ClassNotFoundsException;
use VirCom\Laravel\ModulesLoader\Exceptions\ClassNotExtendsServiceProviderException;

class ModulesLoaderServiceProvider extends ServiceProvider
{
    /**
     * @throws ClassNotFoundsException throws, when class is not exists or was not loaded
     * @throws ClassNotExtendsServiceProviderException throws, when class doesn't extends ServiceProvider class
     * @return void
     */
    public function register()
    {
        $this->registerModules(config("modules"));
    }

    /**
     * @param array $modules
     * @throws ClassNotFoundsException throws, when class is not exists or was not loaded
     * @throws ClassNotExtendsServiceProviderException throws, when class doesn't extends ServiceProvider class
     * @return void
     */
    private function registerModules(array $modules)
    {
        foreach ($modules as $module) {
            $this->registerModule($module);
        }
    }

    /**
     * @param string $module
     * @throws ClassNotFoundsException throws, when class is not exists or was not loaded
     * @throws ClassNotExtendsServiceProviderException throws, when class doesn't extends ServiceProvider class
     * @return void
     */
    private function registerModule(string $module)
    {
        $className = trim($module, "\\") . "\\Module";
        if (!class_exists($className)) {
            throw new ClassNotFoundsException(
                sprintf(
                    "There is no class: %s",
                    $className
                )
            );
        }

        if (!in_array(ServiceProvider::class, class_parents($className))) {
            throw new ClassNotExtendsServiceProviderException(
                sprintf(
                    "Class: %s is not an extension of %s class",
                    $className,
                    ServiceProvider::class
                )
            );
        }

        $this->app->register($className);
    }
}
