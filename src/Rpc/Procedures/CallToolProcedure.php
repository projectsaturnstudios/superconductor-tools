<?php

namespace Superconductor\Capabilities\Tools\Rpc\Procedures;

use Superconductor\Capabilities\Tools\Support\Facades\MCP;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcError;
use Superconductor\Rpc\DTO\Messages\Outgoing\RpcResult;
use Superconductor\Rpc\Enums\RPCErrorCode;
use Superconductor\Rpc\Rpc\Procedures\RpcProcedure;
use Superconductor\Rpc\Support\Attributes\UsesRpcRequest;
use Superconductor\Capabilities\Tools\DTO\Messages\Requests\CallToolRequest;

#[UsesRpcRequest(CallToolRequest::class)]
class CallToolProcedure extends RpcProcedure
{
    public function handle(CallToolRequest $request): RpcResult|RpcError
    {
        $tools = MCP::getTools();
        $tool = $request->getName();
        if(!isset($tools[$tool])) return new RpcError($request->id,
            RPCErrorCode::SERVER_ERROR,
            'Tool not found: ' . $tool,
            $request->toJsonRpc()
        );
        $results = $tools[$tool]->execute($request->getArguments());

        return new RpcResult($request->id,[
            'content' => $results
        ]);
    }
}
