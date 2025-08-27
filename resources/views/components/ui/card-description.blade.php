@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'text-sm text-muted-foreground ' . $class]) }}>
    {{ $slot }}
</div>
