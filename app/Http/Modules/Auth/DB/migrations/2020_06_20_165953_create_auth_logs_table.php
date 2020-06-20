<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('auth_logs', static function (Blueprint $table) {
            $table->id();
            $table->enum('event', [
                'login_failed',
                'login_success',
                'other',
            ]);
            $table->string('ip');
            $table->string('username')->default('');
            $table->text('agent')->default('');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_logs');
    }
}
