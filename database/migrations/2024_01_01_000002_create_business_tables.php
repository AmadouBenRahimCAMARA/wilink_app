<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Revendeurs (Extension de User)
        Schema::create('revendeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->decimal('taux_commission_defaut', 5, 2)->default(10.00);
            $table->decimal('solde_actuel', 10, 2)->default(0.00);
            $table->timestamps();
        });

        // Types de tickets
        Schema::create('types_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // ex: 1H
            $table->decimal('prix_public', 10, 2);
            $table->decimal('prix_revendeur_defaut', 10, 2);
            $table->integer('duree_minutes');
            $table->integer('limite_data_mo')->nullable();
            $table->string('profil_hotspot')->nullable(); // MikroTik Profile
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        // Lots de tickets
        Schema::create('lots_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('numero_lot')->unique();
            $table->foreignId('type_ticket_id')->constrained('types_tickets');
            $table->integer('quantite');
            $table->foreignId('cree_par')->nullable()->constrained('users');
            $table->timestamps();
        });

        // Tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->foreignId('type_ticket_id')->constrained('types_tickets');
            $table->foreignId('lot_ticket_id')->constrained('lots_tickets')->onDelete('cascade');
            
            // Propriétaire actuel (Admin si null, ou Revendeur)
            $table->foreignId('revendeur_actuel_id')->nullable()->constrained('users'); 

            $table->enum('statut', ['cree', 'en_stock_revendeur', 'vendu', 'active', 'expire', 'annule'])->default('cree');
            
            $table->dateTime('date_attribution_revendeur')->nullable();
            $table->dateTime('date_vente')->nullable();
            $table->dateTime('date_activation')->nullable();
            
            // Lien vente (défini plus tard)
            // $table->foreignId('vente_id')->nullable(); 

            $table->string('checksum')->nullable();
            $table->timestamps();
        });

        // Mouvements Stock
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('source_user_id')->nullable()->constrained('users'); // Null si création
            $table->foreignId('destination_user_id')->nullable()->constrained('users');
            $table->string('type_mouvement'); // generation, attribution, vente...
            $table->dateTime('date_mouvement');
            $table->foreignId('cree_par')->nullable()->constrained('users');
            $table->timestamps();
        });

        // Ventes
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('revendeur_id')->constrained('users'); // Le vendeur
            $table->decimal('montant_total', 10, 2);
            $table->decimal('montant_commission', 10, 2)->default(0);
            $table->enum('statut', ['payee', 'annulee'])->default('payee');
            $table->dateTime('date_vente');
            $table->timestamps();
        });

        // Lignes de Vente
        Schema::create('lignes_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_id')->constrained('ventes')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->decimal('prix_unitaire_applique', 10, 2);
            $table->timestamps();
        });
        
        // Update Ticket pour link vente
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('vente_id')->nullable()->constrained('ventes');
        });

        // Règlements Revendeur (Finance)
        Schema::create('reglements_revendeur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revendeur_id')->constrained('users');
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement')->nullable(); // Espèce, MobileMoney
            $table->string('reference_preuve')->nullable();
            $table->foreignId('recu_par')->constrained('users'); // Admin qui encaisse
            $table->timestamps();
        });
        
        // Journal Audit
        Schema::create('journaux_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->nullable()->constrained('users');
            $table->string('action');
            $table->string('table_concernee')->nullable();
            $table->json('ancien_contenu')->nullable();
            $table->json('nouveau_contenu')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journaux_audit');
        Schema::dropIfExists('reglements_revendeur');
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['vente_id']);
            $table->dropColumn('vente_id');
        });
        Schema::dropIfExists('lignes_vente');
        Schema::dropIfExists('ventes');
        Schema::dropIfExists('mouvements_stock');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('lots_tickets');
        Schema::dropIfExists('types_tickets');
        Schema::dropIfExists('revendeurs');
    }
};
