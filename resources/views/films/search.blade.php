<x-layout>
    <p>Информация о фильме, который Вы искали:</p>
    
    <ul>
        @foreach ($films as $film)
            <li><a href="/films/{{ $film->id}}">{{ $film->title }}</a></li>
        @endforeach
    </ul>

</x-layout>