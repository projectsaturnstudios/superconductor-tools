<?php

use Superconductor\Rpc\Support\Facades\RPC;

RPC::method('tools/list', \Superconductor\Capabilities\Tools\Rpc\Procedures\ListToolsProcedure::class);
RPC::method('tools/call', \Superconductor\Capabilities\Tools\Rpc\Procedures\CallToolProcedure::class);
RPC::method('notifications/tools/list_changed', \Superconductor\Capabilities\Tools\Rpc\Procedures\ToolListChangedProcedure::class);
