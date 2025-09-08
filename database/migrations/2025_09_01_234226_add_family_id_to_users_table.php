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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('family_id')->nullable()->after('email')->constrained('families')->nullOnDelete();

            $table
                ->enum('family_role', ['owner', 'parent', 'child', 'guest'])
                ->default('guest')
                ->after('family_id')
                ->comment('家族内での役割');

            $table->timestamp('joined_family_at')->nullable()->after('family_role')->comment('家族参加日時');

            $table->json('family_permissions')->nullable()->after('joined_family_at')->comment('家族内での権限');

            $table->index('family_id');
            $table->index('family_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['family_id']);
            $table->dropColumn(['family_id', 'family_role', 'joined_family_at', 'family_permissions']);
        });
    }
};
