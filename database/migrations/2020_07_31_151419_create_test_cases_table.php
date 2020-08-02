<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')
                ->constrained('requirements')
                ->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->nullable();
            $table->text('title');
            $table->mediumText('description');
            $table->mediumText('preconditions')
                ->nullable();
            $table->foreignId('priority_id')
                ->constrained('requirement_priorities')
                ->nullable();
            $table->dateTime('execution_date')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_cases');
    }
}
