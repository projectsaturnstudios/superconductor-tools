<?php

namespace Superconductor\Capabilities\Tools\DTO\Messages\Requests;

use Superconductor\Rpc\DTO\Messages\Incoming\RpcRequest;

class ListToolsRequest extends RpcRequest
{
    public function __construct(
        int $id,
    ) {
        parent::__construct(id: $id, method: 'tools/list');
    }

    public static function fromRpcRequest(RpcRequest $request): RpcRequest
    {
        return new self($request->id);
    }

}
