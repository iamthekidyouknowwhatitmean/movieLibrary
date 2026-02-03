<x-layout>
    Edit Page

    <div>
        <form action="/films/{{ $film->id }}" method="POST">
            @csrf
            @method("PATCH");

            <input type="text" value="{{ $film->name }}" name="name">
            <button type="submit">Update</button>
        </form>
        
    </div>
</x-layout>