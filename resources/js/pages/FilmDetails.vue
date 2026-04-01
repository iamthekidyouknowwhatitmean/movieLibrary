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
        <div class="info">
            <div class="title flex items-end gap-1.5">
                <h1 class="text-white font-bold text-[32px] leading-8">The Witch <span class="text-[#DDEEFF] text-[17px] font-light text-decoration-line: underline">2015</span></h1>
                <p class="font-light director m-0 leading-[22.6px] pb-1">Directed by <span class="text-[#DDEEFF]">Robert Eggers</span></p>
            </div>
            <div class="pt-7.5">
                <div class="w-97.5">
                    <h2 class="tagline uppercase">Evil takes many forms.</h2>
                    <p class="overview pt-2.5 text-[16px]">
                        In 1630, a farmer relocates his family to a remote plot of land on the edge of a forest where strange, unsettling things happen.
                        With suspicion and paranoia mounting, each family member’s faith, loyalty and love are tested in shocking ways.
                    </p>
                </div>

                <div class="tabbed-content text-[#00E054] flex gap-4.25 pt-8.75 text-[13px]">
                    <button class="uppercase">Cast</button>
                    <button class="uppercase">Crew</button>
                    <button class="uppercase">Details</button>
                    <button class="uppercase">Genres</button>
                    <button class="uppercase">Releases</button>

                </div>

            </div>
        </div>

    </div>
</template>

