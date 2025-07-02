<?php

Rpc::method('tools', \MCP\Capabilities\Tools\Rpc\Controllers\ToolsController::class);
Rpc::method('notifications/tools', \MCP\Capabilities\Tools\Rpc\Controllers\ToolsNotificationsController::class);
