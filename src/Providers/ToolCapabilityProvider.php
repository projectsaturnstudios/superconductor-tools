<?php

namespace MCP\Capabilities\Tools\Providers;

use Illuminate\Support\ServiceProvider;
use MCP\Capabilities\Tools\Console\Commands\MakeToolCommand;
use MCP\Capabilities\Tools\Console\Commands\ListToolsCommand;
use MCP\Capabilities\Tools\Console\Commands\InstallToolPackageCommand;
use MCP\Capabilities\Tools\RequestRouting\ToolRegistrar;

class ToolCapabilityProvider extends ServiceProvider
{
    protected array $configs = [
        'mcp.capabilities.server.tools' => __DIR__.'/../../config/capabilities/server/tools.php',
    ];

    protected array $commands = [
        MakeToolCommand::class,
        ListToolsCommand::class,
        InstallToolPackageCommand::class,
    ];

    public function register(): void
    {
        $this->registerConfigs();
    }

    public function boot(): void
    {
        $this->publishConfigs();
        $this->registerTools();
        $this->registerCommands();
    }

    protected function publishConfigs() : void
    {
        $this->publishes([
            $this->configs['mcp.capabilities.server.tools'] => config_path('mcp/capabilities/server/tools.php'),
        ], ['mcp', 'mcp.capabilities', 'mcp.capabilities.server', 'mcp.capabilities.server.tools']);
    }

    protected function registerConfigs() : void
    {
        foreach ($this->configs as $key => $path) {
            $this->mergeConfigFrom($path, $key);
        }
    }

    protected function registerTools():  void
    {
        ToolRegistrar::boot();
        // Register the package's tools route file
        $this->loadRoutesFrom(__DIR__.'/../../routes/tools.php');

        // Check if there is a tools.php route in the main source's routes folder
        $mainToolsRoutePath = base_path('routes/tools.php');
        if (file_exists($mainToolsRoutePath)) {
            $this->loadRoutesFrom($mainToolsRoutePath);
        }
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }
}
