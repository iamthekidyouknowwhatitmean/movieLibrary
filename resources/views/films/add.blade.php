<x-layout>
    Add Films

    <form action="/films" method="POST">
        @csrf

        <input type="text" name="name">
        <button type="submit">Add</button>
    </form>
</x-layout>