<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalsToTables extends Migration
{
    public function up()
    {
        // Add total_sales to the sales table
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('total_sales', 15, 2)->nullable()->after('selling_price');
        });

        // Add total_purchase to the purchases table
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('total_purchase', 15, 2)->nullable()->after('buying_price');
        });

        // Add total_expense to the expenses table
        Schema::table('expenses', function (Blueprint $table) {
            $table->decimal('total_expense', 15, 2)->nullable()->after('buying_price');
        });
    }

    public function down()
    {
        // Remove the columns if the migration is rolled back
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('total_sales');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('total_purchase');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('total_expense');
        });
    }
}