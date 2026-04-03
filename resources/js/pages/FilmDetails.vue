<script setup>
    import WatchedIcon from '@r/images/icons/watched.svg';
    import WatchedLargeIcon from '@r/images/icons/watched-large.svg';
    import LikesLargeIcon from '@r/images/icons/likes-large.svg';
    import WatchlistIcon from '@r/images/icons/watchlist.svg';
    import ListsIcon from '@r/images/icons/lists.svg';
    import LikesIcon from '@r/images/icons/likes.svg';
    import StarIcon from '@r/images/icons/star.svg';
    import Poster from '@r/images/poster.jpg';

</script>

<template>
    <div class="flex gap-[50px]">
        <div class="poster">
            <img class="" :src="Poster" alt="">
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
            <div class="flex gap-12.5 pt-7.5">
                <div>
                    <div class="w-97.5">
                        <h2 class="tagline uppercase">Evil takes many forms.</h2>
                        <p class="overview pt-2.5 text-[16px]">
                            In 1630, a farmer relocates his family to a remote plot of land on the edge of a forest where strange, unsettling things happen.
                            With suspicion and paranoia mounting, each family member’s faith, loyalty and love are tested in shocking ways.
                        </p>
                    </div>

                    <div class="tabbed-content text-[#00E054] flex gap-4.25 pt-8.75 text-[13px]">
                        <button class="uppercase cursor-pointer h-[24px]">Cast</button>
                        <button class="uppercase cursor-pointer h-[24px]">Crew</button>
                        <button class="uppercase cursor-pointer h-[24px]">Details</button>
                        <button class="uppercase cursor-pointer h-[24px]">Genres</button>
                        <button class="uppercase cursor-pointer h-[24px]">Releases</button>
                    </div>

                    <hr class="border-t border-[#2C3440] w-full mx-auto">

                    <div class="content pt-[20px] flex flex-wrap gap-1 text-[12px]">
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Anya Taylor Joy</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Ralph Ineson</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Kate Dickie</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Harvey Scrimshaw</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Ellie Granger</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Lucas Dawson</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Julian Ritchings</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Batsheba Garnett</span>
                        <span class="bg-[#283038] px-[6px] py-[3px] rounded drop-shadow-sm shadow-[#283038]">Sarah Stephens</span>
                    </div>

                    <div>
                        <span>122 mins More at <a href="">IMDB</a><a href="#">TMDB</a></span>
                    </div>
                </div>
                <div>
                    <div class="bg-[#445566] rounded flex flex-col items-center">
                        <div class="grid w-57.5 grid-cols-[90px_50px_90px] py-2.5">
                            <button class="flex flex-col items-center cursor-pointer">
                                <img :src="WatchedLargeIcon" alt="" class="w-12.5 h-10">
                                <span>Logged</span>
                            </button>

                            <button class="flex flex-col items-center cursor-pointer">
                                <img :src="LikesLargeIcon" alt="" class="w-12.5 h-10">
                                <span>Liked</span>
                            </button>

                            <button class="flex flex-col items-center cursor-pointer">
                                <img :src="WatchlistIcon" alt="" class="w-12.5 h-10">
                                <span>Watchlist</span>
                            </button>
                        </div>
                        <hr class="border-t border-[#14181C] w-full mx-auto" />
                        <div class="text-center py-2.5">
                            <span>Rated</span>
                            <div class="flex gap-1.25">
                                <button>
                                    <img :src="StarIcon" alt="">
                                </button>
                                <button>
                                    <img :src="StarIcon" alt="">
                                </button>
                                <button>
                                    <img :src="StarIcon" alt="">
                                </button>
                                <button>
                                    <img :src="StarIcon" alt="">
                                </button>
                                <button>
                                    <img :src="StarIcon" alt="">
                                </button>
                            </div>
                        </div>
                        <hr class="border-t border-[#14181C] w-full mx-auto" />
                        <div class="py-2.5">
                            <button class="cursor-pointer">
                                <span>Show your activity</span>
                            </button>
                        </div>
                        <hr class="border-t border-[#14181C] w-full mx-auto" />
                        <div class="py-2.5">
                            <button class="cursor-pointer">
                                <span>Review or log again...</span>
                            </button>
                        </div>
                        <hr class="border-t border-[#14181C] w-full mx-auto" />
                        <div class="py-2.5">
                            <button class="cursor-pointer">
                                <span>Add to lists...</span>
                            </button>
                        </div>
                        <hr class="border-t border-[#14181C] w-full mx-auto" />
                        <div class="py-2.5">
                            <button class="cursor-pointer">
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                    <div class="pt-[32px]">
                        <div class="flex justify-between uppercase">
                            <h2>ratings</h2>
                            <p>49 fans</p>
                        </div>
                        <div>
                            тут должен быть график
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

