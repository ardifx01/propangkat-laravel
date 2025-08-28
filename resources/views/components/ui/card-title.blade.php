@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'text-2xl font-semibold leading-none tracking-tight ' . $class]) }}>
    {{ $slot }}
</div>
