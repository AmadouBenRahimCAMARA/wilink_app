# Wilink International - WiFi Zone Manager

Application Web de gestion des revendeurs et des tickets WiFi pour Wilink International.
Cette plateforme centralise la création des tickets Internet, leur distribution aux revendeurs, et le suivi financier, avec une intégration native pour serveur RADIUS (FreeRADIUS).

## 🚀 Fonctionnalités Clés

*   **Gestion des Tickets** : Génération de lots de tickets (codes uniques) avec sécurisation.
*   **Gestion des Stocks** : Attribution de stocks aux revendeurs (Transfert Admin -> Revendeur).
*   **Espace Revendeur (POS)** : Interface de vente simplifiée pour les revendeurs (Mobile Friendly).
*   **Finance** : Suivi des ventes, commissions et dettes des revendeurs.
*   **Intégration Réseau** : Synchronisation automatique des tickets vers la base de données RADIUS (`radcheck`, `radusergroup`).

## 🛠 Pré-requis techniques

*   PHP 8.0 ou supérieur
*   MySQL 5.7 ou supérieur
*   Composer
*   Un serveur Web (Apache/Nginx) ou `php artisan serve`

## 📦 Installation

1.  **Cloner le projet**
    ```bash
    git clone https://github.com/votre-repo/wilink-app.git
    cd wilink-app
    ```

2.  **Installer les dépendances**
    ```bash
    composer install --no-dev --prefer-dist
    # Ou si en dev : composer install
    ```

3.  **Configuration**
    *   Dupliquer `.env.example` en `.env`.
    *   Configurer la base de données :
        ```ini
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=wilink_app
        DB_USERNAME=root
        DB_PASSWORD=votre_mot_de_passe
        ```

    *   **Configuration Email (Test Local)** :
        Pour tester la réinitialisation de mot de passe sans envoyer de vrais emails, utilisez le driver `log` :
        ```ini
        MAIL_MAILER=log
        ```
        Les emails seront écrits dans `storage/logs/laravel.log`.

4.  **Base de données & Données de test**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```
    *Ceci installera les tables Laravel, les tables métier (tickets, ventes...) et les tables RADIUS.*

## 🔑 Accès par défaut (Seeder)

Une fois le `db:seed` exécuté, vous pouvez vous connecter avec :

### 👑 Espace Administrateur
*   **URL** : `/` (Redirige vers `/admin/tickets`)
*   **Email** : `admin@wilink.com`
*   **Mot de passe** : `password`
*   **Fonctions** : Générer lots, Attribuer stock, Voir rapports.

### 💼 Espace Revendeur
*   **URL** : `/` (Redirige vers `/reseller`)
*   **Email** : `vendeur@wilink.com`
*   **Mot de passe** : `password`
*   **Fonctions** : Vendre un ticket (Sortie de stock), Voir solde.

## 📡 Configuration RADIUS (FreeRADIUS)

L'application écrit directement dans les tables standards du schéma SQL FreeRADIUS.
Pour connecter votre serveur NAS (MikroTik) :

1.  Configurez votre FreeRADIUS pour utiliser le driver `sql`.
2.  Pointez la configuration `mods-available/sql` vers la base de données `wilink_app`.
3.  Utilisez la requête standard (déjà compatible avec les tables `radcheck` créées par l'app).

## 📝 Auteur
Conçu pour Wilink International.
Stack : Laravel 9, Bootstrap 5.2.3 (Vite), MySQL 5.7+, FreeRADIUS.
