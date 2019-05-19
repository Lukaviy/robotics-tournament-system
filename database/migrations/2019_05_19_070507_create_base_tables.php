<?php declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTables extends Migration
{
    public function up() : void
    {
        Schema::create('tournaments', function (Blueprint $table) : void
        {
            $table->bigIncrements('id');
            $table->text('name');
            $table->timestampTz('created_at');
            $table->timestampTz('updated_at');
        });

        Schema::create('robot_types', function (Blueprint $table) : void
        {
            $table->bigIncrements('id');
            $table->text('name');
        });

        Schema::create('problems', function (Blueprint $table) : void
        {
            $table->bigIncrements('id');
            $table->text('name');
            $table->bigInteger('tournament_id');
            $table->bigInteger('robot_type_id');
            $table->timestampTz('created_at');
            $table->timestampTz('updated_at');

            $table->foreign('robot_type_id')->on('robot_types')->references('id');
            $table->foreign('tournament_id')->on('tournaments')->references('id');
        });

        Schema::create('solutions', function (Blueprint $table) : void
        {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('problem_id');
            $table->text('repository');
            $table->text('commit');
            $table->timestampTz('created_at');
            $table->timestampTz('updated_at');

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('problem_id')->on('problems')->references('id');
        });
    }

    public function down() : void
    {
        foreach (['problems', 'solutions', 'robot_types', 'tournaments'] as $tableName)
            Schema::drop($tableName);
    }
}
