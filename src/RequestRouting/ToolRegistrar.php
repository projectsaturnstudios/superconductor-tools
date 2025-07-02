<?php

namespace MCP\Capabilities\Tools\RequestRouting;

use MCP\Capabilities\CapabilityRegistrar;
use MCP\Capabilities\RequestRouting\CapabilityRegistrationService;

class ToolRegistrar extends CapabilityRegistrationService
{
    public static function setCapability(CapabilityRegistrar &$registrar, string $name, string $class): void
    {
        $registrar->setServerCapability('tools', $name, $class);
    }

    public static function boot(): void
    {
        app()->singleton('mcp-capability.tool', fn() => new static());
    }
}
