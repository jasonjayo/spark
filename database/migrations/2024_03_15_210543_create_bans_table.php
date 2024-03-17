<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained(table: "users");
            $table->foreignId("admin_id")->constrained(table: "users");
            $table->foreignId("report_id")->nullable()->constrained();
            $table->string("reason", 255);
            $table->timestamp("active_from")->nullable();
            $table->timestamp("active_to")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bans');
    }
};
