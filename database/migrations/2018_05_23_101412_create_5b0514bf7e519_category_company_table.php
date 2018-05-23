<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5b0514bf7e519CategoryCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('category_company')) {
            Schema::create('category_company', function (Blueprint $table) {
                $table->integer('category_id')->unsigned()->nullable();
                $table->foreign('category_id', 'fk_p_3346_3347_company_ca_5b0514bf7e5cb')->references('id')->on('categories')->onDelete('cascade');
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', 'fk_p_3347_3346_category_c_5b0514bf7e610')->references('id')->on('companies')->onDelete('cascade');
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_company');
    }
}
