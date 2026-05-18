<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-5']) }}>
    <div class="text-xs font-semibold text-slate-500">{{ $title }}</div>
    <div class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
        {{ $value }}
    </div>
</div>

