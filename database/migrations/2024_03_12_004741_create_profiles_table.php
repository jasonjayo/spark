<?php

use App\Models\User;
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
        Schema::create('profiles', function (Blueprint $table) {
            // $table->id("user_id");
            $table->foreignId("user_id")->constrained();
            // $table->timestamps();
            $table->char("gender", 1);
            $table->string("tagline", 50);
            $table->string("bio", 1000);
            $table->string("university", 50);
            $table->string("work", 50);
            $table->enum("interested_in", ["MEN", "WOMEN", "ALL"]);
            $table->enum("seeking", ["SHORTTERM", "LONGTERM", "UNKNOWN"]);
            $table->string("fav_movie", 50);
            $table->string("fav_food", 50);
            $table->string("fav_song", 50);
            $table->string("personality_type", 4);
            $table->float("height", 3, 2);
            $table->string("languages", 50);
            $table->timestamp("last_active");
            $table->string("location", 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
