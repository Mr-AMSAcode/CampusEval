# 🌐 ENDPOINTS DISPONIBLES

## 🔑 Authentication Routes

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/login` | login | guest | Show login form |
| POST | `/login` | login | guest | Process login |
| GET | `/register` | register | guest | Show registration form |
| POST | `/register` | register | guest | Process student registration |
| POST | `/logout` | logout | auth | Logout user |
| GET | `/forgot-password` | password.request | guest | Password reset form |
| POST | `/forgot-password` | password.email | guest | Send reset email |
| GET | `/reset-password/{token}` | password.reset | guest | Reset password form |
| POST | `/reset-password` | password.store | guest | Process password reset |

---

## 🎯 Dashboard Routes

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/` | home | - | Home (redirects to login/dashboard) |
| GET | `/dashboard` | dashboard | auth | Main dashboard (role-based) |
| GET  | `/profile` | profile.edit | auth | Edit profile |
| PATCH | `/profile` | profile.update | auth | Update profile |
| DELETE | `/profile` | profile.destroy | auth | Delete profile |

---

## 📋 Invitation Routes (Guest)

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/invitation/{token}` | invitation.show | guest | Show invitation form |
| POST | `/invitation/{token}` | invitation.accept | guest | Accept invitation + set password |

---

## 👥 User Management Routes (Admin)

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/admin/users` | users.index | auth,CheckRole:super_admin | List all users |
| GET | `/admin/users/create` | users.create | auth,CheckRole:super_admin | Show user creation form |
| POST | `/admin/users` | users.store | auth,CheckRole:super_admin | Store new user + send invitation |
| GET | `/admin/users/{user}` | users.show | auth,CheckRole:super_admin | Show user details |
| GET | `/admin/users/{user}/edit` | users.edit | auth,CheckRole:super_admin | Show user edit form |
| PATCH | `/admin/users/{user}` | users.update | auth,CheckRole:super_admin | Update user |
| DELETE | `/admin/users/{user}` | users.destroy | auth,CheckRole:super_admin | Delete user |

---

## 🏢 Department Routes (Admin)

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/admin/departments` | departments.index | auth,CheckRole:super_admin | List departments |
| POST | `/admin/departments` | departments.store | auth,CheckRole:super_admin | Create department |
| PUT | `/admin/departments/{dept}` | departments.update | auth,CheckRole:super_admin | Update department |
| DELETE | `/admin/departments/{dept}` | departments.destroy | auth,CheckRole:super_admin | Delete department |

---

## 🎓 Class Routes (Admin)

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/admin/classes` | classes.index | auth,CheckRole:super_admin | List classes |
| POST | `/admin/classes` | classes.store | auth,CheckRole:super_admin | Create class |
| PUT | `/admin/classes/{class}` | classes.update | auth,CheckRole:super_admin | Update class |
| DELETE | `/admin/classes/{class}` | classes.destroy | auth,CheckRole:super_admin | Delete class |

---

## 📊 Evaluation Routes

| Method | Route | Name | Middleware | Purpose |
|--------|-------|------|------------|---------|
| GET | `/evaluations` | evaluations.index | auth | List evaluations |
| GET | `/evaluations/{eval}` | evaluations.show | auth | Show evaluation |
| POST | `/evaluations/{eval}/submit` | evaluations.submit | auth | Submit evaluation |
| GET | `/evaluations/{eval}/edit` | evaluations.edit | auth | Edit evaluation (draft) |
| PUT | `/evaluations/{eval}` | evaluations.update | auth | Update evaluation |

---

## 🔐 Middleware

### Authentication
- `auth` - Requires authenticated user
- `guest` - Redirects authenticated users to dashboard

### Authorization
- `CheckRole:role_name` - Checks user role
  - Example: `CheckRole:super_admin`
  - Example: `CheckRole:student`
  - Example: `CheckRole:teacher`
  - Example: `CheckRole:staff`

### Email Verification (Optional)
- `verified` - Requires email verification
- `EnsureEmailVerified` - Redirects if email not verified

---

## 📡 JSON API Responses

### Success Response (200)
```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": { /* object */ }
}
```

### Error Response (400/422/500)
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email has already been taken."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

---

## 🎯 ROUTE FLOW BY ROLE

### Super Admin
```
Login (admin@campuseval.test) 
  ↓
/dashboard (Admin Dashboard)
  ├─ /admin/users        (Manage users)
  ├─ /admin/departments  (Manage departments)
  ├─ /admin/classes      (Manage classes)
  ├─ /evaluations        (View evaluations)
  └─ /profile            (Edit profile)
```

### Student
```
Register (/register) OR Invitation Email (/invitation/{token})
  ↓
/dashboard (Student Dashboard)
  ├─ /evaluations      (View my evaluations)
  ├─ /profile          (Edit profile)
  └─ Logout (/logout)
```

### Teacher
```
Invitation Email (/invitation/{token})
  → Accept + Set Password
  ↓
/dashboard (Teacher Dashboard)
  ├─ /evaluations      (View evaluations received from students)
  ├─ /profile          (Edit profile)
  └─ Logout (/logout)
```

### Staff
```
Invitation Email (/invitation/{token})
  → Accept + Set Password
  ↓
/dashboard (Staff Dashboard)
  ├─ /evaluations      (View evaluations if relevant)
  ├─ /profile          (Edit profile)
  └─ Logout (/logout)
```

---

## 🔍 FILTERING & PAGINATION

Most list endpoints support:

```
GET /admin/users?page=1&per_page=15&role=teacher&search=john

Parameters:
- page: int (default: 1)
- per_page: int (default: 15)
- role: string (filter by role)
- search: string (search in name/email)
- sort: string (field name)
- order: 'asc'|'desc'
```

---

## 📝 REQUEST/RESPONSE EXAMPLES

### Login
```bash
POST /login
Content-Type: application/x-www-form-urlencoded

email=admin@campuseval.test
password=CampusEval!2026

# Response (302 Found - Redirect to /dashboard)
```

### Register Student
```bash
POST /register
Content-Type: application/x-www-form-urlencoded

first_name=John
last_name=Doe
email=john@example.com
matricule=GL.TEST.23.A
level=Licence 1
class_id=1
password=SecurePass123
password_confirmation=SecurePass123

# Response (302 Found - Redirect to /dashboard, auto-login)
```

### Accept Invitation
```bash
POST /invitation/abc123token

password=NewPassword123
password_confirmation=NewPassword123

# Response (302 Found - Redirect to /dashboard, auto-login)
```

### Create User (Admin)
```bash
POST /admin/users
Content-Type: application/x-www-form-urlencoded

first_name=Jane
last_name=Smith
email=jane@example.com
role=teacher
specialty=Mathematics
department_id=1

# Response (302 Found - redirect to users.index)
# Email sent to jane@example.com with invitation link
```

---

## 🛡️ ERROR CODES

| Code | Meaning | Example |
|------|---------|---------|
| 200  | OK | Login successful, user retrieved |
| 201  | Created | New user/class created |
| 302  | Redirect | Successful form submission |
| 400  | Bad Request | Invalid parameters |
| 401  | Unauthorized | Not authenticated |
| 403  | Forbidden | Role/permission denied |
| 404  | Not Found | Invalid token/user not found |
| 422  | Validation Error | Email already taken, etc. |
| 500  | Server Error | Database/application error |

---

## 🧪 TESTING ENDPOINTS

### Using cURL

```bash
# Login
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=admin@campuseval.test&password=CampusEval!2026"

# Register
curl -X POST http://localhost:8000/register \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "first_name=John&last_name=Doe&email=john@test.com&..." \
  -c cookies.txt

# Access dashboard (using saved cookies)
curl -b cookies.txt http://localhost:8000/dashboard
```

### Using Postman
1. Import the collection from docs/postman/collection.json (if available)
2. Set environment: `base_url = http://localhost:8000`
3. Login first to get session
4. Then test other endpoints

### Using Laravel Tinker
```bash
php artisan tinker

# Check routes
> Route::getRoutes()->getRoutes()

# Create test user
> User::create([
    'first_name' => 'Test',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'role' => 'student'
  ])
```

---

## 📚 ADDITIONAL NOTES

- All routes are **CSRF protected** (token auto-included in forms)
- **Session management** via Laravel's middleware
- **Rate limiting** not yet implemented (add in middleware if needed)
- **API versioning** not needed for this version
- **Webhooks** not implemented
- **Caching** layers can be added for performance

---

**Generated:** 2025-05-17  
**Last Updated:** 2025-05-17  
**Laravel Version:** 13.8  
**Status:** ✅ Complete
