<?php

namespace NiftyCo\Inkwell\Support;

class PendingWork
{
    protected array $work = [];

    public function add(callable $callback): void
    {
        $this->work[] = $callback;
    }

    public function process(): void
    {
        foreach ($this->work as $callback) {
            try {
                $callback();
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $this->work = [];
    }

    public function count(): int
    {
        return count($this->work);
    }

    public function isEmpty(): bool
    {
        return empty($this->work);
    }

    public function clear(): void
    {
        $this->work = [];
    }
}
