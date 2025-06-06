<?php

use App\Models\Purchase;
use App\Models\Company; // Fixed namespace casing
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Company::class);
            $table->date('date');
            $table->time('time');
            $table->string('qr_code');
            $table->string('product_name');
            $table->string('organisation_name');
            $table->integer('quantity');
            $table->decimal('buying_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
