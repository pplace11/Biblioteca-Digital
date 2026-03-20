@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="px-5 py-6 bg-white border border-slate-200 shadow-sm {{ isset($actions) ? 'sm:rounded-t-2xl' : 'sm:rounded-2xl' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end gap-3 px-5 py-4 bg-slate-50 border border-t-0 border-slate-200 text-end sm:px-6 sm:rounded-b-2xl shadow-sm">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>



