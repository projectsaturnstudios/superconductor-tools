<?php

namespace Superconductor\Capabilities\Tools\Mcp\Capabilities\Tools;

use ReflectionClass;
use Superconductor\Capabilities\Tools\Support\Attributes\ToolCall;

abstract class Tool
{
    public static function getToolDefinition() : ?ToolCall
    {
        $attribute = (new ReflectionClass(new static))->getAttributes(ToolCall::class);
        return $attribute[0]->newInstance();
    }

    public static function getToolInfo(): array
    {
        /** @var ToolCall $attr */
        return (self::getToolDefinition())->toDefinition();
    }

    public static function getInfo(): array
    {
        return static::getToolInfo();
    }
}
