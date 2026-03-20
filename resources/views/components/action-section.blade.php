<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-5 py-6 sm:p-6 bg-white border border-slate-200 shadow-sm sm:rounded-2xl">
            {{ $content }}
        </div>
    </div>
</div>



