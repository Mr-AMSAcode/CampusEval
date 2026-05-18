<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Administrative Staff Dashboard') }}
            </h2>
            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-900">
                {{ __('Your Statistics') }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <x-dashboard-stat-card title="Total evaluations" :value="$stats['total_evaluations']" />
                <x-dashboard-stat-card title="Average rating" :value="$stats['average_rating']" />
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5 xl:col-span-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Anonymous feedbacks') }}</h3>
                    <div class="mt-4 space-y-3">
                        @foreach($stats['recent_evaluations'] as $ev)
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('Rating') }}: <span class="text-amber-700 dark:text-amber-300">{{ number_format($ev->rating, 1) }}</span></div>
                                    <div class="text-xs text-slate-500">{{ $ev->created_at?->format('Y-m-d') }}</div>
                                </div>
                                @if(!empty($ev->comment))
                                    <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">{{ $ev->comment }}</div>
                                @else
                                    <div class="mt-2 text-sm text-slate-500">{{ __('No comment') }}</div>
                                @endif
                            </div>
                        @endforeach
                        @if($stats['recent_evaluations']->isEmpty())
                            <div class="text-sm text-slate-600 dark:text-slate-300">{{ __('No evaluations yet.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

