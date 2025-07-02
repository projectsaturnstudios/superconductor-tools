<?php

namespace MCP\Capabilities\Tools;

use MCP\Capabilities\CapabilityExecution\CapabilityRequest;
use MCP\Capabilities\CapabilityExecution\CapabilityResult;
use ReflectionClass;
use MCP\Mcp\Controllers\McpController;
use MCP\Capabilities\Tools\Support\Attributes\AsTool;
use MCP\Capabilities\Tools\Contracts\ToolUsageContract;

abstract class ToolCall extends McpController implements ToolUsageContract
{
    protected array $params = [];
    public static function _getToolCallAttribute() : ?AsTool
    {
        $attribute = (new ReflectionClass(new static))->getAttributes(AsTool::class);
        return $attribute[0]->newInstance();
    }

    public function getToolCallAttribute() : ?AsTool
    {
        return self::_getToolCallAttribute();
    }

    public static function getToolInfo(): array
    {
        /** @var AsTool $attr */
        return (self::_getToolCallAttribute())->toTool();
    }

    public static function getToolListEntry() : array
    {
        return (self::_getToolCallAttribute())->toValue();
    }
}
