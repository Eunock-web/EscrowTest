<div align="center">
  <h1>🚀 PixelVault - Plateforme Escrow</h1>
  <p>Une plateforme complète de vente de produits numériques intégrant des paiements sécurisés via <strong>FedaPay</strong> (mode Escrow/Séquestre).</p>
</div>

---

## 📌 Présentation

**PixelVault** permet aux créateurs de vendre leurs actifs numériques (designs, templates, scripts) en toute sécurité. Grâce à l'intégration Escrow de FedaPay, l'argent des clients est conservé en sécurité jusqu'à la confirmation de livraison du produit, garantissant ainsi la confiance entre les parties.

### ✨ Fonctionnalités Principales

- **Espace Administrateur** : Modération des produits, gestion des utilisateurs et visualisation des statistiques.
- **Espace Créateur** : Publication d'actifs numériques et tableau de bord des ventes.
- **Espace Client** : Explorateur de la boutique, historique d'achats.
- **Paiements Embarqués** : L'expérience d'achat se fait de manière fluide et sécurisée, sans quitter la plateforme (`checkout.js` embed).

---

## ⚙️ Prérequis

Pour exécuter ce projet localement, assurez-vous d'avoir installé les outils suivants :

- [Docker](https://www.docker.com/) & [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)
- Un compte [FedaPay](https://fedapay.com/) avec des clés API (Sandbox ou Live)

---

## 🛠️ Installation et Démarrage Local (Avec Docker)

Le projet utilise **Docker Compose** pour orchestrer à la fois l'application Laravel et une base de données **PostgreSQL** locale dédiée.

### 1. Cloner le projet

```bash
git clone https://github.com/Eunock-web/EscrowTest.git
cd EscrowTest
```

### 2. Configurer l'Environnement

Dupliquez le fichier de configuration :

```bash
cp .env.example .env
```

Ouvrez le fichier `.env` et ajoutez-y vos clés API FedaPay :

```env
FEDAPAY_PUBLIC_KEY="pk_sandbox_votre_cle_publique"
FEDAPAY_SECRET_KEY="sk_sandbox_votre_cle_secrete"
FEDAPAY_ENVIRONMENT="sandbox" # ou "live" en production
```

### 3. Démarrer les services Docker

Construisez et démarrez les conteneurs (l'application + la base de données PostgreSQL) :

```bash
docker-compose up -d --build
```

> Le premier démarrage prendra quelques minutes le temps d'installer les dépendances `composer` et `npm` contenues dans le `Dockerfile`.

### 4. Finaliser la configuration

Exécutez cette commande pour générer la clé d'application et jouer les migrations de la base de données :

```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan storage:link
```

🌍 L'application est maintenant disponible sur : **[http://localhost:8000](http://localhost:8000)**

---

## ☁️ Déploiement en Production sur Render

Le dépôt inclut la configuration nécessaire pour un déploiement fluide sur [Render](https://render.com/). Le fichier `render.yaml` (Blueprint) permet de déployer une application Web Dockerisée ainsi qu'une base de données PostgreSQL gérée automatiquement.

### Étapes de déploiement (En 1-clic) :

1. Créez un compte sur [Render](https://render.com/).
2. Dans le Dashboard Render, cliquez sur **"New"** -> **"Blueprint"**.
3. Liez votre dépôt GitHub `Eunock-web/EscrowTest`.
4. Render détectera automatiquement le fichier `render.yaml` à la racine.
5. Render vous demandera de remplir les variables d'environnement manquantes :
    - `FEDAPAY_PUBLIC_KEY`
    - `FEDAPAY_SECRET_KEY`
6. Cliquez sur **Apply**. Render va provisionner :
    - Une Base de données PostgreSQL.
    - Un Service Web basé sur le `Dockerfile` fourni.
    - Les variables se connecteront automatiquement grâce au fichier Blueprint.

> **Note d'Architecture :** Dans un environnement de production (comme Render), il est recommandé de séparer le service applicatif (PHP) du service de base de données. C'est pourquoi le `Dockerfile` n'inclut que le serveur applicatif avec l'extension PDO Postgres, tandis que Render provisionne une base propre à côté.

---

## 📂 Structure Docker du Projet

- **`Dockerfile`** : Configure `php:8.2-apache` avec toutes les dépendances nécessaires (PDO Postgres, GD, Node.js pour Vite). Exécute également `composer install` et `npm run build`.
- **`docker-compose.yml`** : Fichier pour le développement local. Démarre l'application et un conteneur PostgreSQL (`pixelvault-db`).
- **`docker-entrypoint.sh`** : Script d'amorçage qui gère dynamiquement le port HTTP exigé par Render, et exécute automatiquement les migrations (`php artisan migrate --force`) lors du lancement du conteneur en production.
- **`render.yaml`** : Fichier IaC (Infrastructure as Code) permettant la mise en ligne simplifiée de l'infrastructure sur Render.

---

<div align="center">
  <i>Développé avec passion pour sécuriser les transactions de biens numériques.</i>
</div>
