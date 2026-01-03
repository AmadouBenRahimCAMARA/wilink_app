<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Table Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // ex: creer_ticket
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Pivot Roles_Permissions
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->timestamps();
        });

        // Modification Users pour ajouter role_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->boolean('actif')->default(true);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'actif', 'deleted_at']);
        });
        Schema::dropIfExists('roles_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
