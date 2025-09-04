<?php

namespace Superconductor\Capabilities\Tools\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Superconductor\Capabilities\Tools\ToolCallRoute;
use Superconductor\Capabilities\Tools\ToolCallRegistrar;

/**
 * @method static ToolCallRoute tool(string $method, string $class)
 * @method static array getTools()
 * @see ToolCallRegistrar
 */
class MCP extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'mcp-tools';
    }
}
