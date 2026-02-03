@props(['size' => 'w500','path' => null])

<img {{ $attributes->merge(['class' => 'object-cover rounded-xl mb-4']) }} src="https://image.tmdb.org/t/p/{{ $size }}/{{ $path }}" alt="">