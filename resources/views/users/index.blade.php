<x-layout>
    <form action="/settings/{{ $user->id }}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <label for="username">Username:</label>
            <x-input id="username" name="username" type="text" value="{{ $user->username }}"/>
        </div>
        <div>
            <label for="">Email:</label>
            <x-input name="email" type="email" value="{{ $user->email }}"/>
        </div>
        <div>
            <label for="first_name">First Name:</label>
            <x-input name="first_name" type="text" value="{{ $user->first_name }}"/>
        </div>
        <div>
            <label for="last_name">Last Name:</label>        
            <x-input name="last_name" type="text" value="{{ $user->last_name }}"/>
        </div>
        <div>
            <label for="location">Location:</label>        
            <x-input name="location" type="text" value="{{ $user->location }}"/>
        </div>
        <div>
            <label for="website">Website:</label>        
            <x-input name="website" type="text" value="{{ $user->webstite }}"/>
        </div>
        <div>
            <label for="bio">Bio:</label>        
            <x-input name="bio" type="text" value="{{ $user->bio }}"/>
        </div>
        
        <x-button>SAVE CHANGES</x-button>
    </form>
    
    <a href="#"></a>
</x-layout>