<x-layout>
    Log In Page
    
    <form action="/login" method="POST">
        @csrf
        
        <input type="email" name="email" placeholder="alex@yahoo.com">
        <input type="password" name="password" placeholder="***">

        <button type="submit">Log In</button>
    </form>
</x-layout>