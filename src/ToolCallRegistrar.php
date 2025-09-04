<?php

namespace Superconductor\Capabilities\Tools;

use Illuminate\Container\Container;

use Superconductor\Capabilities\Tools\Support\Attributes\ToolCall;
use Superconductor\Rpc\Enums\RPCErrorCode;
use Illuminate\Container\Attributes\Singleton;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcError;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcResult;
use Superconductor\Rpc\DTO\Messages\Incoming\RpcRequest;
use Superconductor\Rpc\DTO\Messages\Incoming\RpcNotification;

#[Singleton]
class ToolCallRegistrar
{
    protected array $capabilities = [];

    public function __construct(
        protected Container $app,
    ) {}

    public function tool(string $method, string $action): ToolCallRoute
    {
        $capability = new ToolCallRoute($method, $action, $this);

        $this->capabilities[$method] = $capability;
        return $capability;
    }

    public function getTools(): array
    {
        return $this->capabilities;
    }


    public static function boot(): void
    {
        app()->singleton('mcp-tools', fn(Container $app) => new static($app));
    }
}
