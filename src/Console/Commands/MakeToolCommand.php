<?php

namespace MCP\Capabilities\Tools\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

//#[AsCommand('make:mcp-sample', "Creates an MCP Root handled by Superconductor")]
class MakeToolCommand extends GeneratorCommand
{
    protected $signature = 'make:tool {name} {--route= : The tool route name} {--description= : The tool description}';

    protected $description = "Creates an MCP Tool handled by Superconductor";

    protected $type = 'MCP Tool';

    public function handle(): void
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }

        $this->info('Tool created successfully!');
        
        // Get the route name for registration hint
        $route = $this->getRouteInput();
        $className = $this->getNameInput();
        
        $this->line('');
        $this->line('Add this to your routes/tools.php file:');
        $this->line("MCP::tool('{$route}', \\{$this->getDefaultNamespace('')}\\{$className}::class);");
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/tool.stub');
    }

    /**
     * Build the class with the given name.
     */
    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceTokens($stub)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the stub tokens.
     */
    protected function replaceTokens(string &$stub): static
    {
        $route = $this->getRouteInput();
        $description = $this->getDescriptionInput();

        $stub = str_replace(
            ['{{ tool_name }}', '{{ description }}'],
            [$route, $description],
            $stub
        );

        return $this;
    }

    /**
     * Get the tool route input.
     */
    protected function getRouteInput(): string
    {
        $route = $this->option('route');
        
        if (!$route) {
            $route = Str::kebab($this->getNameInput());
            $route = str_replace('-tool', '', $route);
        }
        
        return $route;
    }

    /**
     * Get the tool description input.
     */
    protected function getDescriptionInput(): string
    {
        $description = $this->option('description');
        
        if (!$description) {
            $route = $this->getRouteInput();
            $description = 'Handles ' . str_replace('-', ' ', $route) . ' operations';
        }
        
        return $description;
    }

    /**
     * Resolve the fully-qualified path to the stub.
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . "/../../..{$stub}";
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Mcp\Controllers\Tools';
    }
}
