<template>
    <div class="min-h-screen bg-[#14181C] flex flex-col">
        <Header></Header>
        <main class="flex-1 max-w-[950px] mx-auto px-4">
            <router-view></router-view>
        </main>
        <Footer></Footer>
    </div>

</template>

<script>
    import Footer from './components/Footer.vue';
    import Header from './components/Header.vue';
    export default{
        components: {Header,Footer}
    }

</script>
