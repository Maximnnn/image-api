<?php

namespace App\Console\Commands;

use App\Image;
use App\Services\ImageCreator;
use App\Status;
use Illuminate\Console\Command;

class createImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var ImageCreator
     */
    private $imageCreator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ImageCreator $imageCreator)
    {
        parent::__construct();
        $this->imageCreator = $imageCreator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $image = Image::query()
            ->where('status', Status::id(Status::STATUS_PENDING))
            ->orderBy('id', 'asc')
            ->firstOrFail();
        return $this->imageCreator->create($image);
    }
}
