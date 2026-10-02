<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('managers')
            ->where('status', 'active')
            ->update(['status' => '1']);

        DB::table('managers')
            ->where('status', 'inactive')
            ->update(['status' => '0']);

        Schema::table('managers', function (Blueprint $table) {
            $table->boolean('status')
                ->default(true)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('managers', function (Blueprint $table) {
            $table->string('status')
                ->default('active')
                ->change();
        });

        DB::table('managers')
            ->where('status', '1')
            ->update(['status' => 'active']);

        DB::table('managers')
            ->where('status', '0')
            ->update(['status' => 'inactive']);
    }
};
