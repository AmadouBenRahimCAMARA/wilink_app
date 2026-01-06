<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add telephone to users
        Schema::table('users', function (Blueprint $table) {
            $table->string('telephone')->nullable()->after('email');
        });

        // 2. Migrate existing data
        // We take the phone from revendeurs table and put it in the users table
        DB::statement("
            UPDATE users u
            JOIN revendeurs r ON u.id = r.utilisateur_id
            SET u.telephone = r.telephone
            WHERE r.telephone IS NOT NULL
        ");

        // 3. Drop telephone from revendeurs
        Schema::table('revendeurs', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Add telephone back to revendeurs
        Schema::table('revendeurs', function (Blueprint $table) {
            $table->string('telephone')->nullable();
        });

        // 2. Reverse data migration
        DB::statement("
            UPDATE revendeurs r
            JOIN users u ON u.id = r.utilisateur_id
            SET r.telephone = u.telephone
            WHERE u.telephone IS NOT NULL
        ");

        // 3. Drop telephone from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });
    }
};
