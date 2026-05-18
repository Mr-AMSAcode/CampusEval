<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">
                {{ __('CampusEval') }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <x-dashboard-stat-card title="Users" :value="$stats['total_users']" />
                <x-dashboard-stat-card title="Students" :value="$stats['total_students']" />
                <x-dashboard-stat-card title="Teachers" :value="$stats['total_teachers']" />

                <x-dashboard-stat-card title="Staff" :value="$stats['total_staff']" />
                <x-dashboard-stat-card title="Published evaluations" :value="$stats['total_evaluations']" />
                <x-dashboard-stat-card title="Pending moderation" :value="$stats['pending_evaluations']" />
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                <div class="xl:col-span-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Recent published evaluations') }}</h3>
                    </div>
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="py-2">#</th>
                                    <th class="py-2">{{ __('Type') }}</th>
                                    <th class="py-2">{{ __('Target') }}</th>
                                    <th class="py-2">{{ __('Rating') }}</th>
                                    <th class="py-2">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 dark:text-slate-200">
                                @foreach($recent_evaluations as $ev)
                                    <tr class="border-t border-slate-100 dark:border-slate-800">
                                        <td class="py-2">{{ $ev->id }}</td>
                                        <td class="py-2">{{ class_basename($ev->evaluatable_type) }}</td>
                                        <td class="py-2">#{{ $ev->evaluatable_id }}</td>
                                        <td class="py-2">
                                            <span class="font-semibold text-amber-700 dark:text-amber-300">{{ number_format($ev->rating, 1) }}</span>
                                        </td>
                                        <td class="py-2">{{ $ev->created_at?->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                                @if($recent_evaluations->isEmpty())
                                    <tr class="border-t border-slate-100 dark:border-slate-800">
                                        <td class="py-4" colspan="5">{{ __('No data yet.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Top teachers (by rating)') }}</h3>
                    <div class="mt-4 space-y-3">
                        @foreach($top_teachers as $t)
                            <div class="flex items-start justify-between gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $t->user?->getFullNameAttribute() ?? 'Teacher #'.$t->id }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ __('Department') }} #{{ $t->department_id }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500">{{ __('Avg') }}</div>
                                    <div class="text-lg font-bold text-amber-700 dark:text-amber-300">{{ number_format($t->average_rating, 1) }}</div>
                                </div>
                            </div>
                        @endforeach
                        @if($top_teachers->isEmpty())
                            <div class="text-sm text-gray-600 dark:text-slate-300">{{ __('No teachers yet.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

