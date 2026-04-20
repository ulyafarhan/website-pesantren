@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full rounded border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition duration-200 shadow-sm text-sm px-4 py-3']) !!}>