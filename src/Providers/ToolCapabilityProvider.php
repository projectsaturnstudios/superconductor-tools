<?php

namespace Superconductor\Capabilities\Tools\Providers;

use Superconductor\Capabilities\Tools\ToolCallRegistrar;
use ProjectSaturnStudios\LaravelDesignPatterns\Providers\BaseServiceProvider;


class ToolCapabilityProvider extends BaseServiceProvider
{
    protected array $config = [
        'mcp.capabilities.tools' => __DIR__ .'/../../config/tools.php',

    ];

    protected array $publishable_config = [
        ['key' => 'mcp.capabilities.tools', 'file_path' => 'superconductor.php', 'groups' => ['superconductor', 'superconductor.mcp', 'superconductor.capabilities', 'superconductor.capabilities.tools']],
    ];

    protected array $routes = [
        __DIR__.'/../../routes/procedures.php'
    ];

    protected array $commands = [];

    protected array $bootables = [];

    public function register(): void
    {
        $this->registerConfigs();
        ToolCallRegistrar::boot();
    }

}
