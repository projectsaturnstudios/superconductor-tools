<?php

namespace Superconductor\Capabilities\Tools\Rpc\Procedures;

use stdClass;
use Superconductor\Mcp\Servers\MCPServer;
use Superconductor\Rpc\Rpc\Procedures\RpcProcedure;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcError;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcResult;
use Superconductor\Rpc\Support\Attributes\UsesRpcRequest;
use Superconductor\Capabilities\Tools\DTO\Messages\Requests\ListToolsRequest;

#[UsesRpcRequest(ListToolsRequest::class)]
class ListToolsProcedure extends RpcProcedure
{
    public function handle(ListToolsRequest $request): RpcResult|RpcError
    {
        $capabilities = [];
        /** @var MCPServer|null $server */
        $server = $request->getAdditionalData()['server'] ?? null;
        if($server) $capabilities = $server->getTools();

        return new RpcResult($request->id, [
            'tools' => empty($capabilities) ? new stdClass() : $capabilities,
        ]);
    }
}
