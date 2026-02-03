<x-layout>
    Detail Page
    <div class="">
        <p>{{ $film->title }}</p>
        <p>{{ $film->overview }}</p>
    </div>

    <div class="bg-[url('https://image.tmdb.org/t/p/original/{{ $film->backdrop_path }}')] bg-cover bg-center h-64 w-full">
        fff
    </div>
    {{-- <p>{{ $film->poster_path }}</p> --}}
    {{-- <img src="{{ $film->poster_path }}" alt=""> --}}
    {{-- <div>
        <ul>
            <li><button class="text-red-500" form="delete-form">Delete</button></li>
            <li><a href="/films/{{ $film->id }}/edit">Edit</a></li>
            <li><button form="addToFavorites-form">Like</button></li>
        </ul>       
    </div> --}}


    <p>Средний рейтинг: {{ number_format($film->ratings()->avg('rating'), 1) }} / 10</p>

    <form method="POST" action="/films/{{ $film->id }}/rate">
        @csrf
        <label for="rating">Оценка:</label>
        <select name="rating" id="rating">
            @for ($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        <button type="submit">Оценить</button>
    </form>

    <form action="/films/{{ $film->id }}/review" method="POST">
        @csrf
        <textarea class="w-full rounded-2xl border border-gray-300 bg-white p-3 text-gray-700 shadow-sm 
         focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 focus:outline-none 
         placeholder-gray-400 resize-none" id="" rows="5" name="review"></textarea>

         <button
            class="px-5 py-2.5 rounded-2xl bg-indigo-500 text-white font-medium 
                    shadow-sm hover:bg-indigo-600 active:bg-indigo-700 
                    focus:outline-none focus:ring-2 focus:ring-indigo-300 
                    transition duration-200"
            >
            Оставить отзыв
        </button>
    </form>
    
    @foreach ($film->reviews as $review)
        <div>
            <p>{{ $review->user->name }}:</p>
            <p>{{ $review->review }}</p>
        </div>
        
    @endforeach

    <form method="POST" action="/films/{{ $film->id }}" id="delete-form" class="hidden">
        @csrf
        @method("DELETE")
    </form>
    <form method="POST" action="/films/{{ $film->id }}/favorite" id="addToFavorites-form" class="hidden">
        @csrf
    </form>
</x-layout>