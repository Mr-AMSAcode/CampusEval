<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Student Dashboard') }}
            </h2>
            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-900">
                {{ __('Anonymous Evaluation') }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <x-dashboard-stat-card title="Evaluated teachers" :value="$evaluated_teachers" />
                <x-dashboard-stat-card title="Evaluated staff" :value="$evaluated_staff" />
                <x-dashboard-stat-card title="Teachers available" :value="$available_teachers" />
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                <div class="xl:col-span-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Quick actions') }}</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('evaluations.index') }}" class="rounded-xl bg-slate-900 text-white px-4 py-3 hover:bg-black transition">
                            <div class="text-sm font-semibold">{{ __('Create an evaluation') }}</div>
                            <div class="text-xs text-white/70">{{ __('Rate teachers and staff anonymously') }}</div>
                        </a>
                        <a href="{{ route('evaluations.my-evaluations') }}" class="rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-3 hover:bg-slate-100 dark:hover:bg-slate-700 transition border border-slate-200 dark:border-slate-700">
                            <div class="text-sm font-semibold">{{ __('My evaluation history') }}</div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('Track submitted evaluations') }}</div>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Profile') }}</h3>
                    <div class="mt-4 space-y-2 text-sm text-slate-700 dark:text-slate-200">
                        <div class="flex justify-between gap-3">
                            <span class="text-slate-500">{{ __('Name') }}</span>
                            <span class="font-semibold">{{ $student->user?->getFullNameAttribute() ?? $student->student_number }}</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-slate-500">{{ __('Class') }}</span>
                            <span class="font-semibold">{{ $student->class?->name ?? '#'.$student->class_id }}</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-slate-500">{{ __('Status') }}</span>
                            <span class="font-semibold capitalize">{{ $student->status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

