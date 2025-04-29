<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAmountFromExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            if (Schema::hasColumn('expenses', 'amount')) {
                $table->dropColumn('amount'); // Drop the 'amount' column
            }
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable()->after('buying_price'); // Re-add the 'amount' column if rolled back
        });
    }
}