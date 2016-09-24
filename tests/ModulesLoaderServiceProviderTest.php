<?php

namespace VirComTest\Laravel\ModulesLoader;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

use VirCom\Laravel\ModulesLoader\ModulesLoaderServiceProvider;
use VirCom\Laravel\ModulesLoader\Exceptions\ClassNotFoundsException;
use VirCom\Laravel\ModulesLoader\Exceptions\ClassNotExtendsServiceProviderException;

use phpmock\phpunit\PHPMock;

class ModulesLoaderServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    use PHPMock;

    /**
     * @var \Illuminate\Support\ServiceProvider
     */
    private $modulesLoaderServiceProvider;

    private $applicationMock;

    public function setUp()
    {
        $this->applicationMock = $this->getMockBuilder(Application::class)
                                        ->getMock();
        $this->modulesLoaderServiceProvider = new ModulesLoaderServiceProvider($this->applicationMock);
    }


    public function testIsModulesServiceProviderExtendsServiceProviderClass()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->modulesLoaderServiceProvider);
    }

    /**
     * @expectedException \VirCom\Laravel\ModulesLoader\Exceptions\ClassNotFoundsException
     */
    public function testThrowsClassNotFoundsExceptionWhenUnableLoadClass()
    {
        $config = $this->getFunctionMock("VirCom\\Laravel\\ModulesLoader", "config");
        $config->expects($this->once())
            ->willReturn([
                "\\Vendor\\Package\\Subpackage\\Module"
            ]);

        
        $this->applicationMock
            ->expects($this->never())
            ->method("register")
            ->willThrowException(new ClassNotFoundsException());

        $this->modulesLoaderServiceProvider->register();
    }
    
    /**
     * @expectedException \VirCom\Laravel\ModulesLoader\Exceptions\ClassNotExtendsServiceProviderException
     */
    public function testThrowsClassNotExtendsServiceProviderExceptionWhenNoServiceProviderParentClass()
    {
        $config = $this->getFunctionMock("VirCom\\Laravel\\ModulesLoader", "config");
        $config->expects($this->once())->willReturn([
            "VirComTest\\Laravel\\ModulesLoader\\Fixtures\\ClassFixtureNotExtendsServiceManager\\Exceptions"
        ]);

        
        $this->applicationMock
            ->expects($this->never())
            ->method("register")
            ->willThrowException(new ClassNotExtendsServiceProviderException());

        $this->modulesLoaderServiceProvider->register();
    }
    
    public function testSuccessfullRegisterModules()
    {
        $arguments = [
            "VirComTest\\Laravel\\ModulesLoader\\Fixtures\\ClassFixtureExtendsServiceManager"
        ];
        
        $config = $this->getFunctionMock("VirCom\\Laravel\\ModulesLoader", "config");
        $config->expects($this->once())->willReturn($arguments);
        
        $this->applicationMock
            ->expects($this->exactly(count($arguments)))
            ->method("register")
            ->willReturnSelf();
        
        $this->modulesLoaderServiceProvider->register();
    }
}
