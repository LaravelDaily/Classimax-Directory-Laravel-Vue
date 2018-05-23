<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5b0514bf80285RelationshipsToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function(Blueprint $table) {
            if (!Schema::hasColumn('companies', 'city_id')) {
                $table->integer('city_id')->unsigned()->nullable();
                $table->foreign('city_id', '3347_5b0514bf601d0')->references('id')->on('cities')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function(Blueprint $table) {
            
        });
    }
}
