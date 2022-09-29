<?php
namespace kodeops\LaravelConsoleOutput;

use Symfony\Component\Console\Output\ConsoleOutput as SConsoleOutput;

class ConsoleOutput extends SConsoleOutput
{
    public function info($message)
    {
        if (! app()->isProduction() AND function_exists('ray')) {
            ray($message)->color('green');
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $this->writeln("<info>{$message}</info>");
    }

    public function error($message)
    {
        if (! app()->isProduction() AND function_exists('ray')) {
            ray($message)->color('red');
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $this->writeln("<error>{$message}</error>");
    }

    public function comment($message)
    {
        if (! app()->isProduction() AND function_exists('ray')) {
            ray($message);
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $this->writeln("<comment>{$message}</comment>");
    }

    public function depends($message, $success)
    {
        if ($success) {
            return $this->comment($message);
        }
        
        return $this->error($message);
    }

    public function debug($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        if (function_exists('ray')) {
            ray($message);
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }
        
        return $this->writeln("<comment>{$message}</comment>");
    }

    public function dinfo($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        if (function_exists('ray')) {
            ray($message)->color('green');
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $this->writeln("<info>{$message}</info>");
    }

    public function derror($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        if (function_exists('ray')) {
            ray($message)->color('error');
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $this->writeln("<error>{$message}</error>");
    }

    public function dcomment($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        if (function_exists('ray')) {
            ray($message);
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $this->writeln("<comment>{$message}</comment>");
    }
}