<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Schema standard FreeRADIUS.
     */
    public function up()
    {
        // Table principale : Login/Password
        Schema::create('radcheck', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64)->default('')->index();
            $table->string('attribute', 64)->default('Cleartext-Password');
            $table->string('op', 2)->default(':=');
            $table->string('value', 253)->default('');
            $table->timestamps(); // Non standard FreeRADIUS pur, mais utile pour Laravel
        });

        // Table attributs : Durée, Débit, etc.
        Schema::create('radreply', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64)->default('')->index();
            $table->string('attribute', 64)->default('');
            $table->string('op', 2)->default('=');
            $table->string('value', 253)->default('');
            $table->timestamps();
        });

        // Table Groupes (Profils)
        Schema::create('radusergroup', function (Blueprint $table) {
            $table->id(); // ID unique non standard mais pratique
            $table->string('username', 64)->default('')->index();
            $table->string('groupname', 64)->default('')->index();
            $table->integer('priority')->default(1);
            $table->timestamps();
        });

        // Table definition des groupes (radgroupreply)
        Schema::create('radgroupreply', function (Blueprint $table) {
            $table->id();
            $table->string('groupname', 64)->default('');
            $table->string('attribute', 64)->default('');
            $table->string('op', 2)->default('=');
            $table->string('value', 253)->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('radgroupreply');
        Schema::dropIfExists('radusergroup');
        Schema::dropIfExists('radreply');
        Schema::dropIfExists('radcheck');
    }
};
