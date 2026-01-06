@props(['disabled' => false, 'error' => false])

@php
  $baseClasses =
      'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50';
  $errorClasses = 'border-destructive focus-visible:ring-destructive';
  $classes = $error ? "$baseClasses $errorClasses" : $baseClasses;
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>

@if ($error)
  <p class="text-[0.8rem] font-medium text-destructive mt-1">{{ $error }}</p>
@endif
