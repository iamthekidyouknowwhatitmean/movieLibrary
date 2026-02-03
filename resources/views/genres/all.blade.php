<x-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="grid sm:grid-cols-12">
            @foreach ($films as $film)
                <a href="/films/{{ $film->id }}">
                    <x-image size="w92" path="{{ $film->poster_path }}" alt="Item"/>
                </a>
            @endforeach
        </div>
    </div>

     {{ $films->links() }}
</x-layout>
