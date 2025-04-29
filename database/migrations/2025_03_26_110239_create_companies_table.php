<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('owner_id');
            $table->text('name');
            $table->text('email')->nullable();
            $table->text('logo')->nullable();
            $table->text('website')->nullable();
            $table->string('status')->nullable();
            $table->date('licence_expire')->nullable();
            $table->text('address')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('phone_number2')->nullable();
            $table->text('pobox')->nullable();
            
        });
    }

    /*email
    logo
    name
    website
    status
    address
    phone no:
    owner-id
    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
