<x-app-layout>
    <x-slot name="header">
        @if (auth()->user()->isSuperAdmin())
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📊 Tableau de bord Administrateur
            </h2>
        @elseif (auth()->user()->isStudent())
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📚 Tableau de bord Étudiant
            </h2>
        @elseif (auth()->user()->isTeacher())
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                👨‍🏫 Tableau de bord Enseignant
            </h2>
        @elseif (auth()->user()->isStaff())
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                👥 Tableau de bord Personnel
            </h2>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Carte bienvenue -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Bienvenue, {{ auth()->user()->first_name }}! 👋</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Rôle: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                            </p>
                        </div>
                        <div class="text-4xl">
                            @if (auth()->user()->isSuperAdmin())
                                🔐
                            @elseif (auth()->user()->isStudent())
                                🎓
                            @elseif (auth()->user()->isTeacher())
                                📖
                            @else
                                🏢
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu par rôle -->
            @if (auth()->user()->isSuperAdmin())
                @include('dashboards.admin-dashboard')
            @elseif (auth()->user()->isStudent())
                @include('dashboards.student-dashboard')
            @elseif (auth()->user()->isTeacher())
                @include('dashboards.teacher-dashboard')
            @elseif (auth()->user()->isStaff())
                @include('dashboards.staff-dashboard')
            @endif
        </div>
    </div>
</x-app-layout>
