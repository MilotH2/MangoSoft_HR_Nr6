<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string("firstname");
            $table->string("lastname");
            $table->string("email");
            $table->string("mobile");
            $table->string("tel")->nullable();
            $table->string("plz");
            $table->string("location");
            $table->string("country");
            $table->string("birthday");
            $table->string("link_to_pdf");
            $table->string("latitude");
            $table->string("longitude");
            $table->string("radius")->nullable();
            $table->decimal("salary_from",10,2);
            $table->decimal("salary_to",10,2);
            $table->tinyInteger("freelancer");
            $table->tinyInteger("permanent");
            $table->string("note")->nullable();
            $table->tinyInteger("status")->default(1);
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
        Schema::dropIfExists('contacts');
    }
}
