<?php

namespace App\Commands\Day1;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use function Termwind\{render};

class solution extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'solution:day1';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        render(<<<HTML
            <div class="py-1 ml-2">
                <div class="py-1">
                    <div class="px-1 bg-blue-300 text-black">Part 1</div>
                    <em class="ml-1">
                        {$this->part1()}
                    </em>
                </div>
                <div class="py-1">
                    <div class="px-1 bg-blue-300 text-black">Part 2</div>
                    <em class="ml-1">
                        {$this->part2()}
                    </em>   
                </div>
            </div>
        HTML);  
    }

    protected function part1()
    {
        return Collection::make($this->getData())
            ->reduce(function ($carry, Collection $item) {
                $sum = $item->sum();
                return $sum > $carry ? $sum : $carry;
                
            }, 0);
    }

    protected function part2()
    {
        return Collection::make($this->getData())
            ->map(fn (Collection $item) => $item->sum())
            ->sort()
            ->pop(3)
            ->sum();
    }

    protected function getData()
    {
        $data = explode("\n", Storage::get('./day1/input.txt'));

        $array = [];
        $currentElf = [];
        foreach ($data as $row) {
            if ($row === "") {
                $array[] = Collection::make($currentElf);
                $currentElf = [];
                continue;
            }

            $currentElf[] = $row;
        }

        return $array;
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
