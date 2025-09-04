<?php

namespace Superconductor\Capabilities\Tools\Rpc\Procedures;

use Superconductor\Mcp\Rpc\Procedures\PingProcedure;
use Superconductor\Rpc\DTO\Messages\Incoming\RpcNotification;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcError;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcResult;
use Superconductor\Rpc\Rpc\Procedures\RpcProcedure;
use Superconductor\Rpc\Support\Attributes\UsesRpcRequest;

#[UsesRpcRequest(RpcNotification::class)]
class ToolListChangedProcedure extends RpcProcedure
{
    public function handle(RpcNotification $request): bool
    {
        return true;
    }
}
