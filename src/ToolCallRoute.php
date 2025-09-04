<?php

namespace Superconductor\Capabilities\Tools;

use Superconductor\Rpc\DTO\Messages\Outgoing\RpcError;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcResult;
use Superconductor\Rpc\DTO\Messages\Incoming\RpcRequest;
use Superconductor\Rpc\DTO\Messages\Incoming\RpcNotification;
use Superconductor\Rpc\DTO\Messages\RpcMessage;
use Superconductor\Rpc\Rpc\Procedures\RpcProcedure;

class ToolCallRoute
{
    public function __construct(
        public readonly string       $method,
        public readonly string       $class,
        protected ToolCallRegistrar &$registrar
    ) {}

    public function execute(?array $arguments): mixed
    {
        return (new $this->class)->handle(...$arguments);
    }
}
