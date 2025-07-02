<?php

namespace MCP\Capabilities\Tools\Console\Commands;

use Illuminate\Console\Command;
use MCP\Support\Facades\MCP;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('tool:list', "Lists all registered SuperconductorMCP Tools")]
class ListToolsCommand extends Command
{
    /**
     * @return void
     */
    public function handle(): int
    {
        $routes = MCP::capability_routes('server','tools');
        
        if (empty($routes)) {
            $this->info('No tools registered.');
            return 0;
        }

        $this->newLine();

        // Prepare data for table display
        $tableData = [];
        foreach ($routes as $route_name => $skill_class) {
            $tableData[] = [
                'tool' => $route_name,
                'class' => $skill_class
            ];
        }

        // Calculate column widths
        $maxToolLength = max(array_map(fn($item) => strlen($item['tool']), $tableData));
        $maxToolLength = max($maxToolLength, 4); // Minimum width for "TOOL" header
        
        $maxClassLength = max(array_map(fn($item) => strlen($item['class']), $tableData));
        $maxClassLength = max($maxClassLength, 5); // Minimum width for "CLASS" header
        
        // Total width calculation (similar to Laravel's approach)
        $totalWidth = $maxToolLength + $maxClassLength + 20; // Extra space for dots and padding
        
        // Display each tool
        foreach ($tableData as $item) {
            $tool = str_pad($item['tool'], $maxToolLength);
            $class = $item['class'];
            
            // Calculate dots needed
            $dotsNeeded = $totalWidth - strlen($tool) - strlen($class) - 2;
            $dots = str_repeat('.', max(1, $dotsNeeded));
            
            $this->line("  <fg=yellow>{$tool}</fg=yellow> {$dots} <fg=blue>{$class}</fg=blue>");
        }

        $this->newLine();
        $this->newLine();
        
        // Summary line (like Laravel's format)
        $toolCount = count($routes);
        $this->line("        <fg=green>Showing [{$toolCount}] tools</fg=green>");
        
        $this->newLine();
        $this->newLine();

        return 0;
    }
}
