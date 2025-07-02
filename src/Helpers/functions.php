<?php

use MCP\Support\Facades\MCP;
use MCP\Capabilities\Tools\RequestRouting\ToolResult;
use MCP\Capabilities\Tools\RequestRouting\ToolRequest;

if(!function_exists('call_tool')) {

    function call_tool(ToolRequest $request): ToolResult
    {
        $response = MCP::action('server', 'tools', $request->name, $request);
        if($response instanceof ToolResult) return $response;

        throw new \Exception("Tool request failed. Expected ToolResult, got " . get_class($response));
    }
}
