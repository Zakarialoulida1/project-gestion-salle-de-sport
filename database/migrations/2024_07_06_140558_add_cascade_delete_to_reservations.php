<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropForeign(['course_id']);
            
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropForeign(['course_id']);
            
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }
}
