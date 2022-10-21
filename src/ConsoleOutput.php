<?php
namespace kodeops\LaravelConsoleOutput;

use Symfony\Component\Console\Output\ConsoleOutput as SConsoleOutput;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Bugsnag\Breadcrumbs\Breadcrumb;

class ConsoleOutput extends SConsoleOutput
{
    private function convertMessageForConsole($message)
    {
        if (is_object($message)) {
            $message = 'is_object';
        }

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return $message;
    }

    private function ray($message, string $color = 'blue')
    {
        if (! app()->isProduction() AND function_exists('ray')) {
            ray($message)->color($color);
        }
    }

    private function breadcrumb($message, $type)
    {
        if (is_array($message)) {
            Bugsnag::leaveBreadcrumb(null, $type, $message);
            return;
        }

        Bugsnag::leaveBreadcrumb($message, $type);
    }

    public function info($message)
    {
        $this->ray($message, 'green');
        $this->breadcrumb($message, Breadcrumb::LOG_TYPE);
        $message = $this->convertMessageForConsole($message);
        return $this->writeln("<info>{$message}</info>");
    }

    public function error($message)
    {
        $this->ray($message, 'red');
        $this->breadcrumb($message, Breadcrumb::ERROR_TYPE);
        $message = $this->convertMessageForConsole($message);
        return $this->writeln("<error>{$message}</error>");
    }

    public function comment($message)
    {
        $this->ray($message);
        $this->breadcrumb($message, Breadcrumb::LOG_TYPE);
        $message = $this->convertMessageForConsole($message);
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

        $this->ray($message);
        $this->breadcrumb($message, Breadcrumb::LOG_TYPE);
        $message = $this->convertMessageForConsole($message);
        return $this->writeln("<comment>{$message}</comment>");
    }

    public function dinfo($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        $this->ray($message, 'green');
        $this->breadcrumb($message, Breadcrumb::LOG_TYPE);
        $message = $this->convertMessageForConsole($message);
        return $this->writeln("<info>{$message}</info>");
    }

    public function derror($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        $this->ray($message, 'red');
        $this->breadcrumb($message, Breadcrumb::ERROR_TYPE);
        $message = $this->convertMessageForConsole($message);
        return $this->writeln("<error>{$message}</error>");
    }

    public function dcomment($message)
    {
        if (! env('APP_DEBUG')) {
            return;
        }

        $this->ray($message);
        $this->breadcrumb($message, Breadcrumb::LOG_TYPE);
        $message = $this->convertMessageForConsole($message);
        return $this->writeln("<comment>{$message}</comment>");
    }
}