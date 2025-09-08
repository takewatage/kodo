<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('family_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('family_id')->constrained('families')->cascadeOnDelete();
            $table->string('email')->comment('招待先メールアドレス');
            $table->string('token', 64)->unique()->comment('招待トークン');
            $table
                ->enum('role', ['parent', 'child', 'guest'])
                ->default('guest')
                ->comment('招待される役割');
            $table->foreignUuid('invited_by')->comment('招待者')->constrained('users');
            $table->timestamps();

            //            $table->index('token');
            //            $table->index('email');
            //            $table->index(['family_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_invitations');
    }
};
