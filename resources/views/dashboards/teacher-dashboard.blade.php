<!-- Teacher Dashboard Stats -->
@php
    $teacher = auth()->user()->teacher;
    $departments = $teacher ? $teacher->departments : collect();
    $evaluations = $teacher ? $teacher->evaluations()->count() : 0;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm mb-1">Mes Départements</p>
                <p class="text-3xl font-bold">{{ $departments->count() }}</p>
            </div>
            <span class="text-4xl opacity-30">🏛️</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-emerald-100 text-sm mb-1">Spécialité</p>
                <p class="text-xl font-bold">{{ $teacher ? $teacher->specialty : 'N/A' }}</p>
            </div>
            <span class="text-4xl opacity-30">📖</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100 text-sm mb-1">Évaluations</p>
                <p class="text-3xl font-bold">{{ $evaluations }}</p>
            </div>
            <span class="text-4xl opacity-30">📋</span>
        </div>
    </div>
</div>

<!-- Mes Départements -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">🏛️ Mes Départements</h3>
    </div>
    <div class="p-6">
        @if ($departments->count() > 0)
            <div class="space-y-3">
                @foreach ($departments as $dept)
                    <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border-l-4 border-blue-500">
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $dept->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            📚 {{ $dept->classes->count() }} classe(s)
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">Aucun département assigné</p>
        @endif
    </div>
</div>

<!-- Mes Évaluations -->
<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📋 Mes Évaluations Récentes</h3>
    </div>
    <div class="p-6">
        @if ($teacher && $teacher->evaluations()->count() > 0)
            <div class="space-y-3">
                @foreach ($teacher->evaluations()->latest()->take(5)->get() as $eval)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Évaluation par {{ $eval->student->first_name ?? 'Étudiant' }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if ($eval->submitted_at)
                                    ✅ Soumise
                                @else
                                    ⏳ Brouillon
                                @endif
                            </p>
                        </div>
                        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                            Consulter
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 dark:text-gray-400">Aucune évaluation pour le moment</p>
            </div>
        @endif
    </div>
</div>

<!-- Informations -->
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
            <label class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Matrice</label>
            <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ auth()->user()->matricule }}</p>
        </div>
    </div>
</div>
