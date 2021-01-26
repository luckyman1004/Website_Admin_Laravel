<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reconciliations', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id');
            $table->integer('account_id');
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->double('closing_balance', 15, 4)->default('0.0000');
            $table->boolean('reconciled');
            $table->timestamps();
            $table->softDeletes();

            $table->index('business_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reconciliations');
    }
}
