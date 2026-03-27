<script setup>
    import WatchedIcon from '@r/images/icons/watched.svg';
    import ListsIcon from '@r/images/icons/lists.svg';
    import LikesIcon from '@r/images/icons/likes.svg';
</script>

<template>
    <div class="flex gap-[50px]">
        <div class="poster">
            <img class="w-[230px] h-[345px] bg-black" src="" alt="">
            <div class="flex gap-2.5 justify-center pt-2.5 text-[#667788]">
                <div class="flex items-center">
                    <img :src="WatchedIcon" alt="" class="">
                    <span class="pl-[4px]">617К</span>
                </div>
                <div class="flex items-center">
                    <img :src="ListsIcon" alt="" class="">
                    <span class="pl-[4px]">114К</span>
                </div>
                <div class="flex items-center">
                    <img :src="LikesIcon" alt="" class="">
                    <span class="pl-[4px]">109К</span>
                </div>
            </div>
        </div>
        <div class="film_info">
            <div class="title">
                <h1 class="font-bold text-[32px] text-white">The Witch</h1>

            </div>
        </div>

    </div>
</template>


