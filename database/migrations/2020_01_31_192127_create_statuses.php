<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statuses = [
            ['name' => 'pending', 'title' => 'Pending'],
            ['name' => 'in_progress', 'title' => 'In Progress'],
            ['name' => 'failed', 'title' => 'Failed'],
            ['name' => 'done', 'title' => 'Done']
        ];
        foreach ($statuses as $status)
            \App\Status::query()->create($status);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::delete('delete from statuses');
    }
}
