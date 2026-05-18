<!-- Student Dashboard Stats -->
@php
    $student = auth()->user()->student;
    $evaluationsCompleted = $student ? $student->evaluations()->whereNotNull('submitted_at')->count() : 0;
    $studentClass = $student ? $student->class : null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm mb-1">Mon Matricule</p>
                <p class="text-xl font-bold">{{ auth()->user()->matricule }}</p>
            </div>
            <span class="text-4xl opacity-30">🆔</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-emerald-100 text-sm mb-1">Niveau d'étude</p>
                <p class="text-xl font-bold">{{ $student ? $student->level : 'N/A' }}</p>
            </div>
            <span class="text-4xl opacity-30">📚</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100 text-sm mb-1">Ma classe</p>
                <p class="text-xl font-bold">{{ $studentClass ? $studentClass->name : 'N/A' }}</p>
            </div>
            <span class="text-4xl opacity-30">🎯</span>
        </div>
    </div>
</div>

<!-- Évaluations -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📋 Mes Évaluations</h3>
    </div>
    <div class="p-6">
        @if ($student && $student->evaluations()->count() > 0)
            <div class="space-y-3">
                @foreach ($student->evaluations()->latest()->get() as $evaluation)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border-l-4 border-blue-500">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $evaluation->evaluatable->first_name ?? 'Évaluation' }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if ($evaluation->submitted_at)
                                    ✅ Soumise le {{ \Carbon\Carbon::parse($evaluation->submitted_at)->format('d/m/Y') }}
                                @else
                                    ⏳ En attente
                                @endif
                            </p>
                        </div>
                        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                            Voir
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 dark:text-gray-400">Aucune évaluation pour le moment</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Les évaluations seront ajoutées par vos enseignants</p>
            </div>
        @endif
    </div>
</div>

<!-- Informations compte -->
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
            <label class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Statut</label>
            <p class="mt-1">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                    ✅ Actif
                </span>
            </p>
        </div>
    </div>
</div>
