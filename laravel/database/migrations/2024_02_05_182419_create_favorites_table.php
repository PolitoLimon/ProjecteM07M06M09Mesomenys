<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->primary('id')->first();
        });
    }

    public function down()
    {
        // No need to define a down() method for this migration
    }
};
