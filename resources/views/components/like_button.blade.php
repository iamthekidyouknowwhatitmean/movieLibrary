{{-- @props(['post']) --}}

@php
    $liked = auth()->check();
@endphp

<button 
    class="flex items-center gap-1 select-none"
>
    <svg 
        id="" 
        xmlns="http://www.w3.org/2000/svg" 
        viewBox="0 0 24 24" 
        fill="{{ $liked ? 'rgb(239 68 68)' : 'none' }}" 
        stroke="currentColor" 
        stroke-width="2" 
        class="w-6 h-6 transition-all duration-200 {{ $liked ? 'scale-110 text-red-500' : 'text-gray-400 hover:text-red-400' }}"
    >
        <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            d="M21 8.25c0-2.485-2.014-4.5-4.5-4.5-1.74 0-3.278 1.008-4.027 2.487A4.498 4.498 0 0 0 8.25 3.75C5.764 3.75 3.75 5.765 3.75 8.25c0 7.22 8.25 12 8.25 12s8.25-4.78 8.25-12z" 
        />
    </svg>
</button>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.querySelector('#like-btn-{{ $post->id }}');
    const icon = document.querySelector('#like-icon-{{ $post->id }}');
    const count = document.querySelector('#like-count-{{ $post->id }}');

    btn.addEventListener('click', async () => {
        const response = await fetch(`/posts/{{ $post->id }}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        // Обновляем цвет и анимацию
        if (data.liked) {
            icon.setAttribute('fill', 'rgb(239 68 68)');
            icon.classList.add('scale-125');
            icon.classList.add('text-red-500');
            icon.classList.remove('text-gray-400');
            setTimeout(() => icon.classList.remove('scale-125'), 200);
        } else {
            icon.setAttribute('fill', 'none');
            icon.classList.add('text-gray-400');
            icon.classList.remove('text-red-500');
        }

        count.textContent = data.count;
    });
});
</script>
@endpush
