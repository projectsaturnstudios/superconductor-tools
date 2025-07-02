<?php

namespace MCP\Capabilities\Tools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('mcp:install-tools', 'Installs the tools package by publishing the config and creating a routes file')]
class InstallToolPackageCommand extends Command
{
    public function handle(): int
    {
        $this->info('🚀 Installing Superconductor MCP Tools Package...');
        $this->newLine();

        $actions = [];

        // Step 1: Check and publish config
        $configPath = config_path('mcp/capabilities/server/tools.php');
        
        if (File::exists($configPath)) {
            $this->line('✅ Config already exists: <fg=cyan>config/mcp/capabilities/server/tools.php</fg=cyan>');
        } else {
            $this->line('📝 Publishing configuration...');
            $this->call('vendor:publish', [
                '--tag' => 'mcp.capabilities.server.tools',
                '--force' => false
            ]);
            $actions[] = 'Published MCP tools configuration';
            $this->line('✅ Config published: <fg=green>config/mcp/capabilities/server/tools.php</fg=green>');
        }

        // Step 2: Check and copy routes file
        $routesPath = base_path('routes/tools.php');
        $packageRoutesPath = __DIR__ . '/../../../routes/tools.php';

        if (File::exists($routesPath)) {
            $this->line('✅ Routes file already exists: <fg=cyan>routes/tools.php</fg=cyan>');
        } else {
            if (File::exists($packageRoutesPath)) {
                $this->line('📄 Creating routes file...');
                
                // Ensure routes directory exists
                File::ensureDirectoryExists(dirname($routesPath));
                
                // Copy the routes file
                File::copy($packageRoutesPath, $routesPath);
                $actions[] = 'Created tools routes file';
                $this->line('✅ Routes file created: <fg=green>routes/tools.php</fg=green>');
            } else {
                $this->error('❌ Package routes file not found. This might be a package issue.');
                return 1;
            }
        }

        $this->newLine();

        // Step 3: Report what we did with fun emojis
        if (empty($actions)) {
            $this->info('🎉 Everything was already set up! No changes needed.');
            $this->line('   Your MCP Tools package is ready to rock! 🎸');
        } else {
            $this->info('🎉 Installation complete! Here\'s what we did:');
            foreach ($actions as $action) {
                $this->line("   🔧 {$action}");
            }
        }

        $this->newLine();
        $this->line('Next steps:');
        $this->line('  1. 🛠️  Create tools: <fg=yellow>php artisan make:tool MyAwesomeTool</fg=yellow>');
        $this->line('  2. 📋 List tools: <fg=yellow>php artisan tool:list</fg=yellow>');
        $this->line('  3. 🚀 Use tools: <fg=yellow>MCP::action(\'server\', \'tools\', \'tool-name\', $request)</fg=yellow>');
        
        $this->newLine();
        $this->info('Happy coding! 🎨✨');

        return 0;
    }
}
