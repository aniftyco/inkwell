<?php

namespace NiftyCo\Inkwell\Support;

use Illuminate\Contracts\Queue\ShouldQueue;

class AsyncDispatcher
{
    protected PendingWork $pendingWork;

    public function __construct(PendingWork $pendingWork)
    {
        $this->pendingWork = $pendingWork;
    }

    public function dispatch(callable|ShouldQueue $work): void
    {
        $driver = config('inkwell.async.driver', 'terminate');

        if ($driver === 'queue' && $work instanceof ShouldQueue) {
            $this->dispatchToQueue($work);
        } else {
            $this->dispatchToTerminate($work);
        }
    }

    protected function dispatchToQueue(ShouldQueue $job): void
    {
        $queue = config('inkwell.async.queue', 'default');

        dispatch($job)->onQueue($queue);
    }

    protected function dispatchToTerminate(callable|ShouldQueue $work): void
    {
        if ($work instanceof ShouldQueue) {
            $this->pendingWork->add(fn () => $work->handle());
        } else {
            $this->pendingWork->add($work);
        }
    }

    public function dispatchNow(callable|ShouldQueue $work): void
    {
        if ($work instanceof ShouldQueue) {
            $work->handle();
        } else {
            $work();
        }
    }

    public function getPendingWork(): PendingWork
    {
        return $this->pendingWork;
    }
}
