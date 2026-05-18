<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ __('Statistics - ') . ucfirst($type) }}</h2>
            <div class="text-xs text-slate-500">{{ __('Anonymous feedbacks only') }}</div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-dashboard-stat-card title="Total" :value="$statistics['total']" />
                <x-dashboard-stat-card title="Average" :value="$statistics['avg_rounded']" />
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-slate-900 dark:text-white">{{ __('Published feedbacks') }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ __('Student identity is hidden by design.') }}</p>

                <div class="mt-5 space-y-4">
                    @foreach($evaluations as $ev)
                        <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/60">
                            <div class="flex items-start justify-between gap-3">
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ __('Rating') }}: <span class="text-amber-700 dark:text-amber-300">{{ number_format($ev->rating, 1) }}</span>
                                </div>
                                <div class="text-xs text-slate-500">{{ $ev->created_at?->format('Y-m-d') }}</div>
                            </div>
                            @if($ev->comment)
                                <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">{{ $ev->comment }}</div>
                            @else
                                <div class="mt-2 text-sm text-slate-500">{{ __('No comment') }}</div>
                            @endif
                        </div>
                    @endforeach

                    @if($evaluations->isEmpty())
                        <div class="text-sm text-slate-600 dark:text-slate-300">{{ __('No published feedbacks yet.') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

