<template>
    <header class="text-[#99AABB] h-18 flex items-center">
        <div class="flex justify-between items-center w-full max-w-[950px] mx-auto px-4">
            <router-link to="/">
                <h1 class="text-xl font-bold">MovieLibrary</h1>
            </router-link>
            <div class="flex gap-6">
                <router-link to="/details" class="hover:text-white transition">FilmDetails</router-link>
                <a href="#" class="hover:text-white transition">null</a>
                <a href="#" class="hover:text-white transition">null</a>
            </div>
        </div>
    </header>
</template>
