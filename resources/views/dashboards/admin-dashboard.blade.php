<!-- Admin Dashboard Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm mb-1">Total Utilisateurs</p>
                <p class="text-3xl font-bold">{{ \App\Models\User::count() }}</p>
            </div>
            <span class="text-4xl opacity-30">👥</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-emerald-100 text-sm mb-1">Étudiants</p>
                <p class="text-3xl font-bold">{{ \App\Models\Student::count() }}</p>
            </div>
            <span class="text-4xl opacity-30">🎓</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100 text-sm mb-1">Enseignants</p>
                <p class="text-3xl font-bold">{{ \App\Models\Teacher::count() }}</p>
            </div>
            <span class="text-4xl opacity-30">👨‍🏫</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-orange-100 text-sm mb-1">Départements</p>
                <p class="text-3xl font-bold">{{ \App\Models\Department::count() }}</p>
            </div>
            <span class="text-4xl opacity-30">🏛️</span>
        </div>
    </div>
</div>

<!-- Admin Actions -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions Administrateur</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                <div class="text-2xl mb-2">📋</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Gérer les utilisateurs</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Créer, modifier ou supprimer des comptes</p>
            </a>

            <a href="#" class="p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                <div class="text-2xl mb-2">🏢</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Département</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gérer les départements</p>
            </a>

            <a href="#" class="p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                <div class="text-2xl mb-2">🎯</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Classes</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configurer les classes</p>
            </a>
        </div>
    </div>
</div>

<!-- Derniers utilisateurs -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Utilisateurs Récents</h3>
    </div>
    <div class="p-6">
        <div class="space-y-3">
            @forelse (\App\Models\User::latest()->take(5)->get() as $user)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700 rounded">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                    <span class="text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Aucun utilisateur</p>
            @endforelse
        </div>
    </div>
</div>
