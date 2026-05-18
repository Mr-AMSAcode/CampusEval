<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ __('Create Evaluation') }}</h2>
            <div class="text-xs text-slate-500">{{ __('Anonymous, moderated before publishing') }}</div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Teachers evaluables') }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ __('You can evaluate only teachers that you attend') }}</p>

                    <div class="mt-4 space-y-3">
                        @foreach($teachers as $teacher)
                            @php
                                $already = in_array($teacher->id, $evaluatedTeacherIds, true);
                            @endphp
                            <a href="{{ route('evaluations.create', ['type'=>'teacher','id'=>$teacher->id]) }}"
                               class="block p-4 rounded-xl border transition {{ $already ? 'opacity-50 pointer-events-none cursor-not-allowed border-slate-200' : 'bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-750' }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                            {{ $teacher->user?->getFullNameAttribute() ?? 'Teacher #'.$teacher->id }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $teacher->department?->name ?? __('Department') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-slate-500">{{ __('Your status') }}</div>
                                        <div class="text-sm font-semibold {{ $already ? 'text-slate-500' : 'text-amber-700 dark:text-amber-300' }}">
                                            {{ $already ? __('Already evaluated') : __('Available') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @if($teachers->isEmpty())
                            <div class="text-sm text-slate-600 dark:text-slate-300">{{ __('No teachers found for your class.') }}</div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Administrative staff evaluables') }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ __('You can evaluate all staff (one evaluation per staff member).') }}</p>

                    <div class="mt-4 space-y-3">
                        @foreach($staff as $s)
                            @php
                                $already = in_array($s->id, $evaluatedStaffIds, true);
                            @endphp
                            <a href="{{ route('evaluations.create', ['type'=>'staff','id'=>$s->id]) }}"
                               class="block p-4 rounded-xl border transition {{ $already ? 'opacity-50 pointer-events-none cursor-not-allowed border-slate-200' : 'bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-750' }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                            {{ $s->user?->getFullNameAttribute() ?? 'Staff #'.$s->id }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $s->department?->name ?? __('Department') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-slate-500">{{ __('Your status') }}</div>
                                        <div class="text-sm font-semibold {{ $already ? 'text-slate-500' : 'text-emerald-700 dark:text-emerald-300' }}">
                                            {{ $already ? __('Already evaluated') : __('Available') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @if($staff->isEmpty())
                            <div class="text-sm text-slate-600 dark:text-slate-300">{{ __('No staff found.') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-xs text-slate-500">
                {{ __('Tip: evaluations are anonymous and will be published after moderation.') }}
            </div>
        </div>
    </div>
</x-app-layout>

