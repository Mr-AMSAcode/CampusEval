# 🗺️ GUIDE DE NAVIGATION - CampusEval

## 📌 CARTE DE L'APPLICATION

```
┌─────────────────────────────────────────────────────────────┐
│                   http://localhost:8000                      │
│                    (PAGE D'ACCUEIL)                         │
└────────────────┬──────────────────────────────┬─────────────┘
                 │                              │
         ┌───────┴──────┐              ┌────────┴──────┐
         │ NON CONNECTÉ │              │   CONNECTÉ    │
         └───────┬──────┘              └────────┬──────┘
                 │                              │
      ┌──────────┼──────────┐        ┌──────────┴──────────────┐
      ↓          ↓          ↓        ↓                         ↓
   /login   /register   /pwd    /dashboard                  /profile
   (Form)    (Form)    (Reset)   (Principal)                (Edit)
```

---

## 🔐 ÉCRAN LOGIN (`/login`)

### Ce que vous voyez:
```
┌─────────────────────────────────────┐
│        🔐 CampusEval Login           │
├─────────────────────────────────────┤
│ Email: [________________]            │
│ Password: [________________]        │
│ ☑ Se souvenir de moi                │
│                                     │
│ [ Se connecter ]                    │
├─────────────────────────────────────┤
│ Mot de passe oublié? | Créer compte │
├─────────────────────────────────────┤
│ Admin: admin@campuseval.test        │
│ Pwd: CampusEval!2026                │
└─────────────────────────────────────┘
```

### Boutons disponibles:
- **Se connecter** - Connectez-vous avec email/password
- **Mot de passe oublié?** - Récupération de mot de passe → `/forgot-password`
- **Créer un compte** - Inscription étudiant → `/register`

### Pour tester:
1. Email: `admin@campuseval.test`
2. Pwd: `CampusEval!2026`
3. Cliquez "Se connecter"
4. ✅ Redirection automatique vers `/dashboard`

---

## 📝 ÉCRAN REGISTER (`/register`)

### Ce que vous voyez:
```
┌─────────────────────────────────────┐
│    🎓 CampusEval S'inscrire          │
├─────────────────────────────────────┤
│ Prénom: [________________]           │
│ Nom: [________________]              │
│ Email: [________________]            │
│ Matricule: [GL.TEST.23.A]            │
│ Niveau: [Licence 1  ▼]               │
│ Classe: [Sélectionner ▼]             │
│ Mot de passe: [________________]     │
│ Confirmer PWD: [________________]    │
│                                     │
│ [ Créer mon compte ]                 │
├─────────────────────────────────────┤
│ Vous avez déjà un compte? Se connecter
└─────────────────────────────────────┘
```

### Champs obligatoires:
- **Prénom** - Ex: Jean
- **Nom** - Ex: Dupont
- **Email** - Doit être unique
- **Matricule** - Format: `GL.XXXXX.YY.Z` ou `SR.XXXXX.YY.Z`
  - GL = Génie Logiciel
  - SR = Systèmes & Réseaux
- **Niveau** - Dropdown: Licence 1-3, Master 1-2, Doctorat
- **Classe** - Dropdown: Classes disponibles
- **Mot de passe** - Minimum 8 caractères
- **Confirmation** - Doit correspondre

### Pour tester:
1. Remplissez les 8 champs
2. Exemple matricule: `GL.CMRY22.23.K`
3. Cliquez "Créer mon compte"
4. ✅ Auto-login vers `/dashboard`

---

## 📊 DASHBOARD PRINCIPAL (`/dashboard`)

### Vue Administrateur:
```
┌─────────────────────────────────────────────────────┐
│  Menu ≡         📊 Tableau de bord Administrateur  │
├─────────────────────────────────────────────────────┤
│                                                     │
│ Bienvenue, Campus!  🔐                              │
│ Rôle: Super Admin                                   │
│                                                     │
├─────────────────────────────────────────────────────┤
│ STATISTIQUES:                                       │
│ ┌────────┬────────┬────────┬────────┐              │
│ │  👥    │  🎓    │ 👨‍🏫    │  🏛️     │              │
│ │Users: 25│Etud: 12│Profs: 5│Dept: 3 │              │
│ └────────┴────────┴────────┴────────┘              │
│                                                     │
│ ACTIONS:                                            │
│ ┌──────────────┬──────────────┬──────────────┐     │
│ │  📋 Gérer    │  🏢 Dept     │  🎯 Classes  │     │
│ │  utilisateurs │              │              │     │
│ └──────────────┴──────────────┴──────────────┘     │
│                                                     │
│ DERNIERS UTILISATEURS:                              │
│ • John Doe (john@ex.com) - Student                 │
│ • Jane Smith (jane@ex.com) - Teacher               │
│ ...                                                 │
│                                                     │
└─────────────────────────────────────────────────────┘
```

**Menu (Top-Left):**
- Home (Dashboard)
- Manage Users (Admin only)
- Settings (Profile)
- Logout

### Vue Étudiant:
```
┌─────────────────────────────────────────────────────┐
│  Menu ≡         📚 Tableau de bord Étudiant       │
├─────────────────────────────────────────────────────┤
│                                                     │
│ Bienvenue, Jean!  🎓                                │
│ Rôle: Étudiant                                      │
│                                                     │
│ ┌──────────────┬──────────────┬──────────────┐     │
│ │  🆔 Matricule│ 📚 Niveau    │ 🎯 Classe    │     │
│ │ GL.TEST.25.A │ Licence 1    │ L1-A         │     │
│ └──────────────┴──────────────┴──────────────┘     │
│                                                     │
│ 📋 MES ÉVALUATIONS:                                │
│ • Éval: Professeur Math - ⏳ En attente           │
│ • Éval: Professeur Phys - ✅ Soumise              │
│ ...                                                 │
│                                                     │
│ 👤 MES INFORMATIONS:                               │
│ Prénom: Jean | Nom: Dupont                         │
│ Email: jean@example.com | ✅ Actif                │
│                                                     │
└─────────────────────────────────────────────────────┘
```

### Vue Enseignant:
```
┌─────────────────────────────────────────────────────┐
│  Menu ≡         👨‍🏫 Tableau de bord Enseignant    │
├─────────────────────────────────────────────────────┤
│                                                     │
│ Bienvenue, Alice!  📖                               │
│ Rôle: Enseignant                                    │
│                                                     │
│ ┌──────────────┬──────────────┬──────────────┐     │
│ │  🏛️ Depts    │ 📖 Spécialité │ 📋 Évals    │     │
│ │ 2 depts      │ Mathématiques │ 15 évals    │     │
│ └──────────────┴──────────────┴──────────────┘     │
│                                                     │
│ 🏛️ MES DÉPARTEMENTS:                              │
│ • Département Informatique                         │
│ • Département Sciences                             │
│                                                     │
│ 📋 MES ÉVALUATIONS REÇUES:                         │
│ • Éval de Student1 - ✅ Soumise                    │
│ • Éval de Student2 - ⏳ Brouillon                  │
│                                                     │
└─────────────────────────────────────────────────────┘
```

### Vue Personnel (Staff):
```
┌─────────────────────────────────────────────────────┐
│  Menu ≡         👥 Tableau de bord Personnel      │
├─────────────────────────────────────────────────────┤
│                                                     │
│ Bienvenue, Robert!  💼                              │
│ Rôle: Personnel                                     │
│                                                     │
│ ┌──────────────┬──────────────┬──────────────┐     │
│ │  💼 Position │ 🏛️ Département│ ✅ Statut    │     │
│ │ Secrétaire   │ Admin        │ Actif       │     │
│ └──────────────┴──────────────┴──────────────┘     │
│                                                     │
│ 📌 MES RESPONSABILITÉS:                             │
│ • Soutien Administratif                            │
│ • Gestion des Utilisateurs                         │
│ • Rapports et Statistiques                         │
│                                                     │
│ 👤 MES INFORMATIONS:                               │
│ Prénom: Robert | Nom: Martin                       │
│ Email: robert@example.com | ✅ Actif              │
│                                                     │
└─────────────────────────────────────────────────────┘
```

---

## ⚙️ MENU DE NAVIGATION (Top-Left)

Cliquez sur le menu "≡" ou le logo pour voir:

```
┌─────────────────────────────┐
│ CampusEval                  │
│ ─────────────────────────── │
│ > 📊 Dashboard              │
│ > 👤 Profile                │
│ > ⚙️  Settings (si admin)   │
│ ─────────────────────────── │
│ 🔚 Logout                   │
└─────────────────────────────┘
```

### Boutons:
- **Dashboard** - Retour au tableau de bord principal
- **Profile** - Éditer votre profil personnel
- **Settings** - Admin uniquement
- **Logout** - Se déconnecter

---

## 📧 SYSTÈME D'INVITATION (Email)

### Pour l'Admin:
1. Allez au dashboard admin
2. Cliquez "Gérer les utilisateurs" (si implémenté)
3. Créez un nouvel utilisateur (Rôle: Enseignant ou Personnel)
4. Entrez email + infos
5. Cliquez "Créer et Inviter"
6. ✅ Email d'invitation envoyé

### Pour l'Utilisateur Invité:
1. Reçoit un email avec lien: `http://localhost:8000/invitation/{token}`
2. Clique le lien
3. Voit un formulaire de mot de passe
4. Rentre nouveau mot de passe (2 champs)
5. Clique "Accepter et se connecter"
6. ✅ Auto-login vers son dashboard

---

## 🎯 SCÉNARIOS D'UTILISATION

### Scénario 1: Admin Setup
1. `/login` → Entrez admin@campuseval.test / CampusEval!2026
2. Voir tableau de bord admin complet
3. Stats en temps réel affichées
4. Peut créer/éditer/supprimer utilisateurs (si CRUD implémenté)

### Scénario 2: Student Registration
1. Aller à `/register`
2. Remplir 8 champs
3. Soumettre
4. ✅ Auto-login
5. Voir student dashboard avec infos personnelles

### Scénario 3: Teacher Invitation
1. Admin crée compte teacher
2. Teacher reçoit email
3. Clique lien → `/invitation/{token}`
4. Rentre mot de passe
5. ✅ Auto-login
6. Voir teacher dashboard

---

## 🔍 NAVIGATION PAR CLAVIER

| Raccourci | Action |
|-----------|--------|
| Tab | Aller au champ suivant |
| Shift+Tab | Aller au champ précédent |
| Enter | Soumettre le formulaire |
| Escape | Fermer les dropdowns |

---

## 📱 RESPONSIVE DESIGN

L'appli s'adapte à l'écran:

**Desktop (1920px+)**
```
┌─── Menu | Contenu Principal ──────────┐
│ Sidebar|  Full width dashboard       │
└─────────────────────────────────────┘
```

**Tablet (768px - 1024px)**
```
┌──────────────────────────┐
│ Hamburger Menu | Content │
│     (responsive grid)     │
└──────────────────────────┘
```

**Mobile (< 768px)**
```
┌──────────────────┐
│ ≡ Menu | Content │
│ (stack vertical) │
└──────────────────┘
```

---

## 🌓 DARK MODE

Activez le mode sombre:
1. Cliquez sur l'icône soleil/lune (si disponible)
2. Ou via préférences système
3. L'interface change automatiquement

---

## ✅ CHECKLIST DE NAVIGATION

- [ ] Pouvez-vous accéder à la page `/login`?
- [ ] Pouvez-vous vous connecter en tant qu'admin?
- [ ] Le dashboard affiche-t-il le contenu correct par rôle?
- [ ] Les menus sont-ils navigables?
- [ ] Pouvez-vous créer un compte étudiant?
- [ ] Pouvez-vous vous déconnecter?
- [ ] Les pages sont-elles responsive?
- [ ] Le mode sombre fonctionne-t-il?

---

## 🚨 ERREURS COURANTES DE NAVIGATION

### "Page not found" en cliquant sur un lien
- Vérifiez que le serveur `php artisan serve` est en cours
- Redémarrez le serveur
- Rafraîchissez le navigateur

### "Menu ne s'affiche pas"
- Cliquez sur le hamburger ≡ en haut à gauche
- Vérifiez que JavaScript n'est pas bloqué
- Essayez un autre navigateur

### "Boutons ne répondent pas"
- Vérifiez que le CSS s'est correctement compilé
- Exécutez `npm run build`
- Videz le cache du navigateur (Ctrl+Shift+Delete)

---

## 💡 ASTUCES

1. **Bookmark utiles:**
   - `/login` - Si vous êtes déconnecté
   - `/dashboard` - Aller directement à votre tableau de bord
   - `/register` - Créer un nouveau compte

2. **DevTools:**
   - Appuyez sur F12 pour ouvrir les DevTools
   - Allez à l'onglet "Console" pour les erreurs JavaScript
   - L'onglet "Network" pour les erreurs de connexion

3. **Tester différents rôles:**
   - Utilisez des navigateurs différents (admin dans Chrome, student dans Firefox)
   - Ou utilisez les onglets privés/incognito

---

**Dernière mise à jour:** 2025-05-17  
**Version:** 1.0.0  
**Status:** ✅ Production Ready
