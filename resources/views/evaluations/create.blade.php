<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Evaluation - ') . ucfirst($type) }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6">
                <form method="POST" action="{{ route('evaluations.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="evaluatable_id" value="{{ $evaluatable->id }}">

                    <div>
                        <div class="text-sm text-slate-500">{{ __('Target') }}</div>
                        <div class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ $evaluatable->user?->getFullNameAttribute() ?? ucfirst($type).' #'.$evaluatable->id }}
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('Rating') }}</label>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @for($i=1;$i<=5;$i++)
                                <label class="cursor-pointer rounded-xl border border-slate-200 dark:border-slate-700 p-3 hover:border-amber-300 transition">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold">{{ $i }}</span>
                                        <span class="text-xs text-slate-500">/ 5</span>
                                    </div>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('Comment (optional)') }}</label>
                        <textarea name="comment" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-3 text-sm text-slate-900 dark:text-white" placeholder="{{ __('Write an anonymous feedback...') }}"></textarea>
                        @error('comment')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900 dark:text-white">{{ __('Criteria') }}</h3>
                            <div class="text-xs text-slate-500">{{ __('Choose scores from 1 to 5') }}</div>
                        </div>

                        @foreach($criteria as $c)
                            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $c->name }}</div>
                                        @if($c->description)
                                            <div class="text-xs text-slate-500 mt-1">{{ $c->description }}</div>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500">{{ __('Weight') }}: {{ $c->weight ?? 1 }}</div>
                                </div>

                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-5 gap-2">
                                    @for($score=1;$score<=5;$score++)
                                        <label class="cursor-pointer rounded-xl border border-slate-200 dark:border-slate-700 p-2 hover:border-violet-300 transition text-center">
                                            <input type="radio" class="hidden" name="criteria_scores[{{ $c->id }}]" value="{{ $score }}" required>
                                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $score }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('evaluations.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                            {{ __('Back') }}
                        </a>
                        <button type="submit" class="px-5 py-3 rounded-xl bg-gradient-to-r from-slate-900 to-violet-700 text-white font-semibold hover:opacity-95 transition">
                            {{ __('Submit evaluation') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

