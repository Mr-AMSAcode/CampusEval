# 🎯 Guide d'Accès CampusEval

**Statut du projet:** ✅ **COMPLÈTEMENT OPÉRATIONNEL**

Tous les systèmes d'authentification, d'inscription et de gestion des rôles functional et testés.

---

## 🚀 Démarrage Rapide

### 1. Initialiser la base de données (si première fois)
```bash
php artisan migrate:fresh --seed
```

Cela créera automatiquement :
- ✅ Super administrateur
- ✅ Départements de test
- ✅ Classes de test
- ✅ Utilisateurs de test (enseignants, personnel, étudiants)

### 2. Démarrer le serveur PHP
```bash
php artisan serve
```

L'application sera accessible à: `http://localhost:8000`

---

## 🔐 Accès Administrateur

**URL:** `http://localhost:8000/login`

| Champ | Valeur |
|-------|--------|
| Email | `admin@campuseval.test` |
| Mot de passe | `CampusEval!2026` |

### Après connexion (Administrateur)
- ✅ Redirection automatique vers `/dashboard`
- 📊 **Statistiques en temps réel:** Nombre d'utilisateurs, étudiants, enseignants, départements
- 👥 **Gestion des utilisateurs:** Voir la liste des derniers utilisateurs créés
- 🎯 **Actions disponibles:** Gérer utilisateurs, départements, classes

---

## 📚 Accès Étudiant - Deux Options

### Option A : Créer son compte (Auto-inscription)

**URL:** `http://localhost:8000/register`

**Champs obligatoires:**
- ✏️ Prénom
- ✏️ Nom
- 📧 Email (unique)
- 🆔 Matricule (format: `GL.XXXXX.YY.Z` ou `SR.XXXXX.YY.Z`)
- 📚 Niveau d'étude (Licence 1-3, Master 1-2, Doctorat)
- 🎯 Classe (sélectionnée dans la liste)
- 🔒 Mot de passe (minimum 8 caractères)
- ✓ Confirmation du mot de passe

**Exemple de matricule valide:**
- `GL.CMRY22.23.K` (dans le champ Matricule)
- `SR.TECH01.24.A`

**Après soumission:**
- ✅ Compte créé automatiquement
- ✅ Connexion automatique
- ✅ Redirection vers le tableau de bord étudiant

### Option B : Invitation par l'administrateur

1. **Admin crée le compte:** `/admin/users/create` (Rôle: Étudiant)
2. **Email d'invitation envoyée** au nouvel utilisateur
3. **L'étudiant reçoit un lien:** `/invitation/{token}`
4. **L'étudiant complète son compte:** Définit un mot de passe
5. ✅ **Connexion automatique au dashboard**

### Tableau de Bord Étudiant
Affiche:
- 🆔 Votre matricule
- 📚 Votre niveau d'étude
- 🎯 Votre classe
- 📋 Vos évaluations (si assignées)
- 👤 Vos informations personnelles

---

## 👨‍🏫 Accès Enseignant

### Créé par l'Administrateur

**Processus:**
1. Admin accède à `/admin/users/create`
2. Remplit les informations: Email, prénom, nom, spécialité
3. Sélectionne le rôle: **Enseignant**
4. Soumet le formulaire
5. 📧 Une email d'invitation est envoyée

**Pour l'Enseignant:**
1. Clique le lien dans l'email: `/invitation/{token}`
2. Complète son mot de passe (minimum 8 caractères)
3. ✅ Connexion automatique
4. 📊 Accès au tableau de bord enseignant

### Tableau de Bord Enseignant
Affiche:
- 🏛️ Mes départements assignés
- 📖 Ma spécialité
- 📋 Mes évaluations reçues
- 👤 Mes informations personnelles

---

## 👥 Accès Personnel (Staff)

**Processus identique aux enseignants:**
1. Admin crée le compte via `/admin/users/create`
2. Sélectionne le rôle: **Personnel**
3. Remplit: Position, département
4. Email d'invitation envoyée
5. Personnel accepte via `/invitation/{token}`
6. 📊 Accès au tableau de bord personnel

### Tableau de Bord Personnel
Affiche:
- 💼 Votre position
- 🏛️ Votre département
- ✅ Votre statut
- 📌 Vos responsabilités

---

## 🔄 Flux d'Authentification Complet

```
┌─────────────────────────────────────┐
│         Page d'Accueil              │
│    http://localhost:8000            │
└────────┬────────────────────────────┘
         │
         ├─ Utilisateur NON connecté → /login
         │
         └─ Utilisateur connecté → REDIRECTION AUTOMATIQUE
                                   ├─ Super Admin   → /dashboard (vue admin)
                                   ├─ Étudiant      → /dashboard (vue étudiant)
                                   ├─ Enseignant    → /dashboard (vue enseignant)
                                   └─ Personnel     → /dashboard (vue personnel)

INSCRIPTION:
/register → Remplir 8 champs → Validation → Création du compte → Auto-login
                                                                     ↓
                                                          /dashboard (étudiant)

INVITATION (Email):
Email d'invitation → Clic sur lien → /invitation/{token} → Mot de passe
                                                              ↓
                                                    Acceptation → Auto-login
                                                                     ↓
                                                         /dashboard (rôle)
```

---

## 📧 Système d'Invitation (Email)

### Configuration
Pour recevoir les emails réellement, configurez dans `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@campuseval.test
MAIL_FROM_NAME="CampusEval"
```

**Pour tester sans vrai SMTP (Développement):**
```env
MAIL_MAILER=log
```
Les emails seront affichés dans `storage/logs/laravel.log`

---

## 🧪 Tester le Système Complètement

### Test 1: Login Admin
1. Aller à `http://localhost:8000`
2. Vous êtes redirigé vers `/login`
3. Entrer: **admin@campuseval.test / CampusEval!2026**
4. ✅ Vous voyez le dashboard administrateur
5. Bouton "Menu" → "Logout" pour se déconnecter

### Test 2: Créer un compte étudiant
1. `/logout` depuis le dashboard admin
2. Aller à `http://localhost:8000/register`
3. Remplir le formulaire (matricule: `GL.TEST.00.X`)
4. Soumettre
5. ✅ Auto-login vers le dashboard étudiant

### Test 3: Voir un autre rôle
1. `/logout`
2. Lancer dans un **autre navigateur** ou **session privée**
3. Accéder à `http://localhost:8000`
4. Vous êtes guest → `/login`

---

## 🛡️ Sécurité

✅ **Implémenté:**
- Mots de passe hashés avec Bcrypt
- Tokens d'invitation aléatoires (64 caractères)
- Expiration des tokens (7 jours)
- Validation CSRF sur tous les formulaires
- Protection des routes selon les rôles
- Email verification pour les comptes créés

---

## 📁 Fichiers Importants

| Fichier | Purpose |
|---------|---------|
| `routes/web.php` | Routes principales + middleware roles |
| `app/Http/Controllers/Auth/RegisteredUserController.php` | Inscription étudiant avec validation |
| `app/Http/Controllers/Auth/InvitationController.php` | Acceptation invitation + mot de passe |
| `app/Notifications/InvitationNotification.php` | Email d'invitation |
| `resources/views/auth/login.blade.php` | Formulaire de connexion |
| `resources/views/auth/register.blade.php` | Formulaire d'inscription étudiant |
| `resources/views/auth/invitation.blade.php` | Page d'acceptation d'invitation |
| `resources/views/dashboards/` | Dashboards par rôle |

---

## ❓ FAQ

**Q: Je vois une erreur 404 sur `/dashboard`?**
- Vérifiez que vous êtes connecté (`php artisan dump-server` pour debug)
- Réinstallez: `php artisan migrate:fresh --seed`

**Q: Mon mot de passe n'est pas accepté?**
- Vérifiez les majuscules/minuscules: `CampusEval!2026`
- Minimum 8 caractères pour les autres comptes

**Q: Comment créer plus de test users?**
```bash
# Dans tinker
php artisan tinker
> Illuminate\Support\Facades\Hash::make('password')  # générateur
> User::create([...])  # créer manuellement
```

**Q: Comment réinitialiser la base de données?**
```bash
php artisan migrate:reset
php artisan migrate:fresh --seed
```

---

## 📞 Support

Pour un problème:
1. Vérifier `storage/logs/laravel.log`
2. Consulter `php artisan tinker` pour debug
3. Réinstaller la base: `php artisan migrate:fresh --seed`

**Code source:** `/app`, `/routes`, `/resources/views`

---

**Dernière mise à jour:** 2025-05-17  
**Version Laravel:** v13.8  
**Status:** ✅ Production Ready
