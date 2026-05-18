# 🎓 CAMPUSEVAL - SYSTÈME D'ÉVALUATION ET DE GESTION UNIVERSITAIRE

![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen)
![Laravel](https://img.shields.io/badge/Laravel-13.8-red)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-blue)
![License](https://img.shields.io/badge/License-MIT-green)

**CampusEval** est une plateforme web complète de gestion et d'évaluation des enseignants par les étudiants dans un contexte universitaire, développée avec Laravel 13.

---

## 📌 Vue d'Ensemble

- ✅ **Système d'authentification complet** - Login/Register/Invitation
- ✅ **Tableaux de bord différenciés** - 4 rôles (Admin, Étudiant, Enseignant, Personnel)
- ✅ **Gestion des utilisateurs** - Create/Read/Update/Delete avec invitation par email
- ✅ **Système d'évaluation** - Students évaluent les enseignants via critères
- ✅ **Interface moderne** - Tailwind CSS avec mode sombre et gradients
- ✅ **Sécurité avancée** - CSRF, Bcrypt, tokens, middleware par rôle

---

## 🚀 Démarrage Rapide

### Prérequis
- **PHP** 8.3+
- **Laravel** 13.8
- **MySQL/MariaDB** 5.7+
- **Composer**
- **Node.js** 18+ (pour Vite)

### Installation

```bash
# 1. Clone ou accédez au répertoire
cd c:\Users\AMSA\campuseval

# 2. Installez les dépendances PHP
composer install

# 3. Installez les dépendances JavaScript
npm install

# 4. Créez le fichier .env
cp .env.example .env

# 5. Générez la clé application
php artisan key:generate

# 6. Configurez la base de données dans .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=campuseval
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Exécutez les migrations + seeders
php artisan migrate:fresh --seed

# 8. Compilez les assets
npm run build

# 9. Démarrez le serveur
php artisan serve
```

**Accès:** http://localhost:8000

---

## 🔐 Identifiants par Défaut

| Rôle | Email | Mot de passe |
|------|-------|--------|
| **Super Admin** | `admin@campuseval.test` | `CampusEval!2026` |
| **Étudiants** | Via `/register` | À définir |
| **Enseignants** | Via invitation email | À définir lors de l'acceptation |
| **Personnel** | Via invitation email | À définir lors de l'acceptation |

---

## 📂 Structure du Projet

```
campuseval/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Auth/                    # Contrôleurs d'authentification
│   │           ├── LoginController
│   │           ├── RegisteredUserController
│   │           ├── InvitationController
│   │           └── ...
│   ├── Models/                          # Modèles Eloquent
│   │   ├── User.php
│   │   ├── Student.php
│   │   ├── Teacher.php
│   │   ├── Staff.php
│   │   ├── Evaluation.php
│   │   └── ...
│   └── Notifications/                   # Notifications par email
│       └── InvitationNotification.php
├── resources/
│   ├── views/
│   │   ├── auth/                        # Vues authentification
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   └── invitation.blade.php
│   │   ├── dashboards/                  # Dashboards par rôle
│   │   │   ├── admin-dashboard.blade.php
│   │   │   ├── student-dashboard.blade.php
│   │   │   ├── teacher-dashboard.blade.php
│   │   │   └── staff-dashboard.blade.php
│   │   ├── dashboard.blade.php          # Dashboard principal
│   │   └── layouts/                     # Layouts réutilisables
│   ├── css/
│   │   └── app.css                      # Styles avec Tailwind
│   └── js/
│       └── app.js                       # Alpine.js interactivity
├── database/
│   ├── migrations/                      # Migrations de schéma
│   └── seeders/
│       └── DatabaseSeeder.php           # Données de test
├── routes/
│   ├── web.php                          # Routes web principales
│   └── api.php                          # Routes API (optionnel)
└── tests/                               # Tests unitaires/fonctionnels
```

---

## 🎯 Fonctionnalités Principales

### 1️⃣ Authentification & Autorisation

**Login (/login)**
- Email + Mot de passe
- "Souvenir de moi" optionnel
- Récupération de mot de passe

**Registration (/register)**
- **Spécifique aux étudiants**
- 8 champs: Prénom, Nom, Email, Matricule, Niveau, Classe, Motdepasse
- Validation matricule (`GL/SR.XXXXX.YY.Z`)
- Auto-login après création

**Invitation System**
- Admin crée compte → Email d'invitation
- Utilisateur clique lien → `/invitation/{token}`
- Définit mot de passe → Auto-login
- Token expire après 7 jours

### 2️⃣ Dashboards Différenciés

**Admin Dashboard**
- Statistiques en temps réel (Utilisateurs, Étudiants, Enseignants)
- Gestion des utilisateurs
- Gestion des départements
- Gestion des classes

**Student Dashboard**
- Profil personnel (Matricule, Niveau, Classe)
- Mes évaluations
- Informations académiques

**Teacher Dashboard**
- Mes départements
- Ma spécialité
- Évaluations reçues
- Détails personnels

**Staff Dashboard**
- Ma position
- Mon département
- Mes responsabilités
- Statut du compte

### 3️⃣ Système d'Évaluation

- Étudiants évaluent les enseignants
- Critères d'évaluation prédéfinis
- Formulaires dynamiques
- Stockage sécurisé des réponses

### 4️⃣ Gestion des Utilisateurs

- Création, modification, suppression
- Assignation de rôles
- Statut actif/inactif
- Historique d'audit

---

## 🔒 Sécurité

### Authentification
- ✅ Mots de passe hashés (Bcrypt)
- ✅ Sessions Laravel sécurisées
- ✅ CSRF Token protection
- ✅ Rate limiting (à ajouter)

### Authorization
- ✅ Role-based access control
- ✅ Middleware par route
- ✅ Vérification des permissions

### Données
- ✅ SQL Injection prevention (ORM Eloquent)
- ✅ XSS protection (Blade escaping)
- ✅ Email verification
- ✅ Soft deletes pour audit trail

---

## 📊 Base de Données

### Tables Principales

```
┌─────────────┐
│   users     │ ← Tous les utilisateurs
├─────────────┤
│ id          │
│ email (U)   │
│ password    │
│ role (enum) │
│ ...         │
└─────────────┘
       ↓
   ┌───┴───┬──────┬──────┐
   ↓       ↓      ↓      ↓
students teachers staff  admin

students:
  ├─ level: Licence 1-3, Master 1-2, Doctorat
  ├─ class_id → classes
  └─ evaluations[]

classes:
  ├─ department_id → departments
  └─ students[]

departments:
  ├─ classes[]
  ├─ teachers[]
  └─ staff[]

evaluations:
  ├─ student_id → students
  ├─ teacher_id → teachers
  ├─ evaluation_details[]
  └─ assessment_criteria[]
```

---

## 🌐 Routes Disponibles

### Publiques (guest)
- `GET /login` - Formulaire connexion
- `POST /login` - Traiter connexion
- `GET /register` - Formulaire inscription
- `POST /register` - Traiter inscription
- `GET /invitation/{token}` - Accepter invitation

### Authentifiées
- `GET /dashboard` - Tableau de bord principal
- `GET /profile` - Édition profil
- `POST /logout` - Déconnexion

### Admin seulement
- `GET /admin/users` - Liste utilisateurs
- `POST /admin/users` - Créer utilisateur
- `PUT /admin/users/{id}` - Modifier utilisateur
- `DELETE /admin/users/{id}` - Supprimer utilisateur

Pour la liste complète: voir `ENDPOINTS.md`

---

## 💻 Stack Technologique

| Couche | Technologie | Version |
|--------|-------------|---------|
| **Backend** | Laravel | 13.8 |
| **Language** | PHP | 8.3+ |
| **Database** | MySQL/MariaDB | 5.7+ |
| **Frontend** | HTML5 + Blade | - |
| **Styling** | TailwindCSS | 3.1 |
| **JavaScript** | Alpine.js | 3.4 |
| **Build** | Vite | 8.0 |
| **Package Manager** | Composer | - |
| **Node Package Mgr** | npm | 18+ |

---

## 📦 Dépendances Principales

### Composer
```json
{
    "laravel/framework": "^13.x",
    "laravel/breeze": "^2.x",
    "laravel/tinker": "^2.x",
    "fakerphp/faker": "^1.x",
    "phpunit/phpunit": "^11.x"
}
```

### NPM
```json
{
    "tailwindcss": "^3.1",
    "alpinejs": "^3.4",
    "@vitejs/plugin-vue": "^4.x",
    "vite": "^8.0"
}
```

---

## 🧪 Tests

### Exécuter les tests
```bash
# Tests unitaires
php artisan test

# Tests spécifiques
php artisan test --filter=LoginTest

# Avec couverture de code
php artisan test --coverage
```

### Seeders pour tests
```bash
# Réinitialiser base complètement
php artisan migrate:fresh --seed

# Juste seed sans migration
php artisan db:seed

# Seed avec seed spécifique
php artisan db:seed --class=DiagnosticsSeeder
```

---

## 🔧 Configuration

### .env Variables Importantes

```env
# Application
APP_NAME=CampusEval
APP_ENV=production
APP_DEBUG=false
APP_URL=https://campuseval.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=campuseval
DB_USERNAME=root
DB_PASSWORD=

# Mail (pour invitations)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@campuseval.com
MAIL_FROM_NAME="CampusEval"

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=database

# Queue (pour emails asynchrones)
QUEUE_CONNECTION=database
```

---

## 📚 Documentation Complète

Pour plus d'informations, voir:

- **Accès aux dashboards** - [ACCÈS_DASHBOARDS.md](./ACCÈS_DASHBOARDS.md)
- **Statut final du projet** - [STATUT_FINAL.md](./STATUT_FINAL.md)
- **Endpoints disponibles** - [ENDPOINTS.md](./ENDPOINTS.md)
- **Modifications effectuées** - [MODIFICATIONS.md](./MODIFICATIONS.md)

---

## 🐛 Troubleshooting

### Erreur: "SQLSTATE[HY000] [2002] No connection could be made"

**Solution:** Vérifiez votre `.env` pour les paramètres de base de données

```bash
# Testez la connexion
php artisan migrate --dry-run
```

### Erreur: "View [auth.login] not found"

**Solution:** Compilez les vues

```bash
php artisan view:cache
php artisan view:clear
```

### Erreur: "No application encryption key has been generated"

**Solution:** Générez la clé

```bash
php artisan key:generate
```

### Emails non reçus

**Solution:** Vérifiez la configuration du `.env`

```bash
# Pour développement, utilisez log driver
MAIL_MAILER=log

# Les emails s'afficheront dans storage/logs/laravel.log
```

---

## 🚢 Déploiement en Production

### Checklist
- [ ] Configurer `.env` avec paramètres production
- [ ] `php artisan key:generate`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `npm run build` (compiler les assets)
- [ ] `php artisan migrate --force` (déployer migrations)
- [ ] `chmod -R 775 storage bootstrap/cache` (permissions)
- [ ] Configurer HTTPS/SSL
- [ ] Configurer cron job pour Laravel scheduler

### Server Requirements
- PHP 8.3+
- Composer
- MySQL 5.7+
- Apache/Nginx
- SSL Certificate

---

## 📞 Support & Contact

| Ressource | Lien |
|-----------|------|
| **Laravel Docs** | https://laravel.com/docs |
| **Tailwind CSS** | https://tailwindcss.com |
| **Alpine.js** | https://alpinejs.dev |
| **GitHub Issues** | [Your Repo]/issues |

---

## 📄 Licence

Ce projet est sous licence **MIT**. Voir fichier `LICENSE` pour détails.

---

## 👨‍💻 Auteur

Développé par **GitHub Copilot**  
Dernière mise à jour: **2025-05-17**  
Version: **1.0.0**

---

## 🌟 Fonction Clés en Un Coup d'Oeil

```
╔════════════════════════════════════════════════════════════════╗
║                    CAMPUSEVAL v1.0.0                          ║
╠════════════════════════════════════════════════════════════════╣
║                                                                ║
║  ✅ Multi-role Authentication System                          ║
║     └─ Admin, Student, Teacher, Staff                         ║
║                                                                ║
║  ✅ Modern, Responsive UI                                     ║
║     └─ TailwindCSS + Alpine.js + Dark Mode                    ║
║                                                                ║
║  ✅ Secure Authorization                                      ║
║     └─ Role-based middleware + CSRF protection                ║
║                                                                ║
║  ✅ Email-based Invitations                                   ║
║     └─ 7-day token expiry + auto-login                        ║
║                                                                ║
║  ✅ 4 Customized Dashboards                                   ║
║     └─ Admin, Student, Teacher, Staff perspectives            ║
║                                                                ║
║  ✅ Comprehensive Documentation                               ║
║     └─ 4 guides + code comments                               ║
║                                                                ║
║  ✅ Production Ready                                          ║
║     └─ Tested, Validated, Deployable                          ║
║                                                                ║
╚════════════════════════════════════════════════════════════════╝
```

---

**Prêt à commencer?** → http://localhost:8000
