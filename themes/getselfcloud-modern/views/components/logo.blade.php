@php
$lightLogo = config('settings.logo');
$darkLogo = config('settings.logo_dark');
$appName = config('app.name', 'P');
$bundledLogoPath = public_path('getselfcloud-modern/images/getselfcloud-com-V2.png');
$bundledLogoUrl = file_exists($bundledLogoPath) ? asset('getselfcloud-modern/images/getselfcloud-com-V2.png') : null;
$initials = collect(explode(' ', $appName))
    ->filter()
    ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
    ->take(2)
    ->implode('');
@endphp

@if ($lightLogo && $darkLogo)
<img src="{{ Storage::url($lightLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block dark:hidden']) }}>
<img src="{{ Storage::url($darkLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto hidden dark:inline-block']) }}>
@elseif ($lightLogo)
<img src="{{ Storage::url($lightLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@elseif ($darkLogo)
<img src="{{ Storage::url($darkLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@elseif ($bundledLogoUrl)
<img src="{{ $bundledLogoUrl }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@else
<span {{ $attributes->merge(['class' => 'inline-flex size-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-secondary text-sm font-bold text-inverted']) }}>
    {{ $initials ?: 'P' }}
</span>
@endif
