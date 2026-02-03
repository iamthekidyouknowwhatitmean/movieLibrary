<x-layout>
    Register Page
    <form action="/register" method="POST">
        @csrf
        
        <input type="text" name="username" placeholder="Alex">
        <input type="email" name="email" placeholder="alex@yahoo.com">
        <input type="password" name="password" placeholder="***">

        <button type="submit">Registration</button>
    </form>
</x-layout>