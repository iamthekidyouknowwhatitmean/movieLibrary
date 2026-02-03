<x-layout>
    Popular Films
    <form action="/films/search" method="POST">
        @csrf
        <input type="text" name="search" placeholder="Поиск фильмов..." value="">
        <button type="submit">Найти</button>
    </form>

    <form action="/films/genre" method="GET" class="pt-5">
        @csrf
        <label>Choose genre:</label>
        <select name="genre">
            @foreach ($genres as $genre)
                <option class="text-xs" value="{{ $genre->name }}">{{ $genre->name }}</option>
            @endforeach
        </select>
        <input type="submit" value="Submit">
    </form>

    <form method="GET" action="#" class="mt-4">
        <select name="year">
            <option value="">Все годы</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>

        <button type="submit">Фильтровать</button>
    </form>

    <div class="min-h-screen bg-gray-100 p-6">
        <div class="grid gap-6 sm:grid-cols-5">
        <!-- Card -->
            @foreach ($allFilms as $film)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex flex-col items-center">
                    <x-image path="{{ $film->poster_path }}" size="w500" alt="Item"/>
                    <h2 class="text-lg font-semibold text-gray-700">{{ $film->title }}</h2>
                    <p class="text-gray-500 text-sm mt-2 text-center">{{ $film->release_date }}</p>
                    <a href="/films/{{ $film->id }}" class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition">
                        Подробнее
                    </a>
                    <form action="/like/{{ $film->id }}" method="POST">
                        @csrf
                        <button class="text-red-500" type="submit">Like</button>
                    </form>
                    
                    <form action="/watchlist/{{ $film->id }}" method="POST">
                        @csrf
                        <button class="text-green-500"type="submit">Add to watchlist</button>
                    </form>
                </div>    
            @endforeach
            
        </div>
    </div>

    
    {{ $allFilms->links() }}
    
</x-layout>