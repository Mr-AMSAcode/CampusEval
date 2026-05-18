<!-- Staff Dashboard Stats -->
@php
    $staff = auth()->user()->staff;
    $position = $staff ? $staff->position : 'N/A';
    $department = $staff ? $staff->department : null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm mb-1">Position</p>
                <p class="text-xl font-bold">{{ $position }}</p>
            </div>
            <span class="text-4xl opacity-30">💼</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-emerald-100 text-sm mb-1">Département</p>
                <p class="text-xl font-bold">{{ $department ? $department->name : 'N/A' }}</p>
            </div>
            <span class="text-4xl opacity-30">🏛️</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100 text-sm mb-1">Statut</p>
                <p class="text-xl font-bold">{{ auth()->user()->is_active ? 'Actif' : 'Inactif' }}</p>
            </div>
            <span class="text-4xl opacity-30">✅</span>
        </div>
    </div>
</div>

<!-- Actions Personnel -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📌 Mes Responsabilités</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border-l-4 border-blue-500">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Soutien Administratif</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Assurer le bon fonctionnement des opérations administratives</p>
            </div>

            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border-l-4 border-emerald-500">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Gestion des Utilisateurs</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Aider à la gestion des comptes et des données</p>
            </div>

            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border-l-4 border-purple-500">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Rapports et Statistiques</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Générer et analyser les rapports nécessaires</p>
            </div>
        </div>
    </div>
</div>

<!-- Informations personnelles -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">👤 Mes Informations</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Prénom</label>
            <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ auth()->user()->first_name }}</p>
        </div>
        <div>
            <label class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Nom</label>
            <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ auth()->user()->last_name }}</p>
        </div>
        <div>
            <label class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Email</label>
            <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ auth()->user()->email }}</p>
        </div>
        <div>
            <label class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Matricule</label>
            <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ auth()->user()->matricule }}</p>
        </div>
    </div>
</div>
