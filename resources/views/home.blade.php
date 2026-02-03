<x-layout>
    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->username }}!</p>
    @endif
</x-layout>
