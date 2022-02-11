<template>
    <Head title="Home" />
    <LoggedOutLayout class="text-primary-clr">
        <SearchBar />

        <div
            class="pt-3 grid gap-0 md:gap-5 grid-cols-1 md:grid-cols-6 xl:grid-cols-5"
        >
            <div class="col-span-4">
                <!-- audio item -->
                <AudioGridItem :item="audio" :key="audio.id" />
                <!-- Description -->
                <div class="py-5">
                    <h2 class="text-xl py-3">Description:</h2>
                    <span class="text-lg">{{ audio.description }}</span>
                </div>
                <!-- Tags -->
                <div class="mt-4">
                    <span class="mr-3 text-primary-clr font-semibold"
                        >Tags:</span
                    >
                    <span
                        class="text-primary-clr font-semibold bg-secondary-bg px-3 py-2 mr-3 rounded"
                        v-for="tag in tags"
                        :key="tag.id"
                        >{{ tag }}</span
                    >
                </div>
            </div>
            <div
                class="mt-12 md:mt-0 col-span-2 xl:col-span-1 w-full flex grow"
            >
                <div
                    class="xl:text-lg flex grow flex-col p-5 bg-secondary-bg justify-between"
                >
                    <div>
                        <div class="flex justify-between">
                            <span>Bit Depth:</span>
                            <span class="text-secondary-clr"
                                >{{ audio.bit_depth }} bit</span
                            >
                        </div>
                        <div class="flex justify-between">
                            <span>Sample Rate:</span>
                            <span class="text-secondary-clr">{{
                                audio.sample_rate
                            }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Likes:</span>
                            <span class="text-secondary-clr">{{
                                audio.likes
                            }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Plays:</span>
                            <span class="text-secondary-clr">{{
                                audio.plays
                            }}</span>
                        </div>
                    </div>
                    <div class="mt-4 lg:mt-0">
                        <button
                            class="text-base w-full block font-semibold text-primary-bg px-6 py-2 bg-brand-clr hover:bg-brand-clr-hover hover:border-0 rounded"
                        >
                            Download Sound
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </LoggedOutLayout>
</template>

<script>
import LoggedOutLayout from "@/Components/Layouts/LoggedOutLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

import SearchBar from "@/Components/SearchBar";
import AudioGridItem from "@/Components/Grids/AudioGridItem";

export default {
    components: {
        Head,
        Link,
        LoggedOutLayout,
        AudioGridItem,
        SearchBar,
    },
    props: ["audio", "tags"],
};
</script>
