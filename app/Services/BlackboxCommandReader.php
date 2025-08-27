<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BlackboxCommandReader
{
    /**
     * Execute a command and return detailed output
     *
     * @param string $command
     * @param string|null $workingDirectory
     * @param int $timeout
     * @param array $env
     * @return array
     */
    public static function execute(string $command, ?string $workingDirectory = null, int $timeout = 60, array $env = []): array
    {
        $workingDirectory = $workingDirectory ?: base_path();
        
        try {
            $process = Process::fromShellCommandline($command, $workingDirectory, $env);
            $process->setTimeout($timeout);
            $startTime = microtime(true);
            $process->run();
            $endTime = microtime(true);

            return [
                'success' => $process->isSuccessful(),
                'exit_code' => $process->getExitCode(),
                'output' => $process->getOutput(),
                'error_output' => $process->getErrorOutput(),
                'command' => $command,
                'working_directory' => $workingDirectory,
                'execution_time' => $endTime - $startTime,
                'pid' => $process->getPid(),
            ];

        } catch (ProcessFailedException $e) {
            return [
                'success' => false,
                'exit_code' => $e->getProcess()->getExitCode(),
                'output' => '',
                'error_output' => $e->getMessage(),
                'command' => $command,
                'working_directory' => $workingDirectory,
                'execution_time' => 0,
                'pid' => null,
            ];
        }
    }

    /**
     * Execute a command with real-time output streaming
     *
     * @param string $command
     * @param callable $callback
     * @param string|null $workingDirectory
     * @param int $timeout
     * @return array
     */
    public static function executeWithCallback(string $command, callable $callback, ?string $workingDirectory = null, int $timeout = 60): array
    {
        $workingDirectory = $workingDirectory ?: base_path();
        
        $process = Process::fromShellCommandline($command, $workingDirectory);
        $process->setTimeout($timeout);
        
        $output = '';
        $errorOutput = '';
        $startTime = microtime(true);
        
        $process->run(function ($type, $buffer) use (&$output, &$errorOutput, $callback) {
            if ($type === Process::OUT) {
                $output .= $buffer;
                $callback('stdout', $buffer);
            } else {
                $errorOutput .= $buffer;
                $callback('stderr', $buffer);
            }
        });
        
        $endTime = microtime(true);

        return [
            'success' => $process->isSuccessful(),
            'exit_code' => $process->getExitCode(),
            'output' => $output,
            'error_output' => $errorOutput,
            'command' => $command,
            'working_directory' => $workingDirectory,
            'execution_time' => $endTime - $startTime,
        ];
    }

    /**
     * Execute multiple commands in sequence
     *
     * @param array $commands
     * @param string|null $workingDirectory
     * @param int $timeout
     * @return array
     */
    public static function executeMultiple(array $commands, ?string $workingDirectory = null, int $timeout = 60): array
    {
        $results = [];
        
        foreach ($commands as $index => $command) {
            $results[] = [
                'index' => $index,
                'command' => $command,
                'result' => self::execute($command, $workingDirectory, $timeout),
            ];
        }
        
        return $results;
    }

    /**
     * Get system information
     *
     * @return array
     */
    public static function getSystemInfo(): array
    {
        $commands = [
            'php --version',
            'composer --version',
            'git --version',
            'node --version',
            'npm --version',
            'ls -la',
            'pwd',
            'whoami',
        ];

        return self::executeMultiple($commands);
    }

    /**
     * Check if a command exists in the system
     *
     * @param string $command
     * @return bool
     */
    public static function commandExists(string $command): bool
    {
        $checkCommand = 'command -v ' . escapeshellarg($command) . ' >/dev/null 2>&1 && echo "exists" || echo "not found"';
        $result = self::execute($checkCommand);
        return trim($result['output']) === 'exists';
    }

    /**
     * Execute a command and return formatted output for VS Code terminal
     *
     * @param string $command
     * @param string|null $workingDirectory
     * @param int $timeout
     * @return array
     */
    public static function executeForVSCode(string $command, ?string $workingDirectory = null, int $timeout = 60): array
    {
        $result = self::execute($command, $workingDirectory, $timeout);
        
        return [
            'type' => 'terminal',
            'command' => $command,
            'output' => [
                'stdout' => $result['output'],
                'stderr' => $result['error_output'],
            ],
            'exitCode' => $result['exit_code'],
            'success' => $result['success'],
            'timestamp' => now()->toISOString(),
            'executionTime' => $result['execution_time'],
        ];
    }
}
