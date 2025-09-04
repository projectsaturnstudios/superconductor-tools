<?php

namespace Superconductor\Capabilities\Tools\DTO\Messages\Requests;

use Superconductor\Rpc\DTO\Messages\Incoming\RpcRequest;

class CallToolRequest extends RpcRequest
{
    public function __construct(
        int $id,
        public readonly string $name,
        public readonly ?array $arguments = null,
        public readonly ?array $_meta = null,
    ) {
        parent::__construct(id: $id, method: 'tools/call', params: [
            'name' => $name,
            'arguments' => $arguments,
        ]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public static function fromRpcRequest(RpcRequest $request): RpcRequest
    {
        return new self(
            $request->id,
            ...$request->params
        );
    }

}
