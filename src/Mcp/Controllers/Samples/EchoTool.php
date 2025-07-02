<?php

namespace MCP\Capabilities\Tools\Mcp\Controllers\Samples;

use MCP\Capabilities\Tools\ToolCall;
use MCP\Capabilities\Tools\Support\Attributes\AsTool;
use MCP\Capabilities\Tools\RequestRouting\ToolResult;
use MCP\Capabilities\Tools\RequestRouting\ToolRequest;


#[AsTool(
    tool: 'echo',
    description: 'Echoes back the request data for testing purposes',
    inputSchema: [
        'type'   => 'object',
        'properties' => [
            'intended_output' => [
                'type'        => 'string',
                'description' => 'The intended output of the echo.'
            ]
        ],
        'required' => ['intended_output']
    ]
)]
class EchoTool extends ToolCall
{
    protected function prep(ToolRequest $request): void
    {
        if($request->has('intended_result')) $this->exec_params['intended_result'] = $request->get('intended_result');

        else throw new \InvalidArgumentException('Missing required parameter: intended_result');
    }

    protected function exec(string $intended_result) : string
    {
        return $intended_result;
    }

    protected function post(string $result): ToolResult
    {
        return new ToolResult(['text' => $result ?: 'No output provided']);
    }
}
