<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ __('My evaluations') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate-500">
                            <tr>
                                <th class="py-2">#</th>
                                <th class="py-2">{{ __('Target') }}</th>
                                <th class="py-2">{{ __('Rating') }}</th>
                                <th class="py-2">{{ __('Status') }}</th>
                                <th class="py-2">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-800 dark:text-slate-200">
                            @foreach($evaluations as $ev)
                                <tr class="border-t border-slate-100 dark:border-slate-800">
                                    <td class="py-2">{{ $ev->id }}</td>
                                    <td class="py-2">
                                        {{ class_basename($ev->evaluatable_type) }} #{{ $ev->evaluatable_id }}
                                    </td>
                                    <td class="py-2">
                                        <span class="text-amber-700 dark:text-amber-300 font-semibold">{{ number_format($ev->rating, 1) }}</span>
                                    </td>
                                    <td class="py-2">
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold
                                            {{ $ev->status === 'published' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200' }}">
                                            {{ $ev->status }}
                                        </span>
                                    </td>
                                    <td class="py-2">{{ $ev->created_at?->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                            @if($evaluations->isEmpty())
                                <tr class="border-t border-slate-100 dark:border-slate-800">
                                    <td class="py-6" colspan="5">{{ __('No evaluations submitted yet.') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

