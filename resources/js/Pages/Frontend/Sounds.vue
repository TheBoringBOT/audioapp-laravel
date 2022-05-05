<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>
    <GuestAndUserFrontendLayout>
        <ContentContainer>
            <SearchBar :popularTags="popularTags" v-bind:keyword="keyword" />
            <div v-if="soundData.length">
                <h1 class="text-md md:text-lg font-semibold text-secondary-clr">
                    Recently added sounds
                </h1>
                <SoundGrid :soundData="soundData" />
            </div>
            <div class="mt-10 flex flex-col items-center justify-center" v-else>
                <span class="text-5xl">😢</span>
                <h1 class="font-semibold text-primary-clr text-">
                    We found no sounds matching
                    <span
                        class="rounded font-bold text-lg p-1 text-primary-bg bg-brand-clr"
                        >{{ keyword }}</span
                    >
                </h1>
            </div>
        </ContentContainer>
    </GuestAndUserFrontendLayout>
</template>

<script>
import GuestAndUserFrontendLayout from "@/Components/Layouts/GuestAndUserFrontendLayout.vue";
import ContentContainer from "@/Components/Layouts/ContentContainer";
import { Head, Link } from "@inertiajs/inertia-vue3";

import SearchBar from "@/Components/SearchBar";
import SoundGrid from "@/Components/Grids/SoundGrid";

export default {
    components: {
        Head,
        Link,
        GuestAndUserFrontendLayout,
        SoundGrid,
        SearchBar,
        ContentContainer,
    },
    props: ["soundData", "keyword", "popularTags"],
    data() {
        return {
            seo: {
                title: "Discover Amazing free sounds",
                description: "Find sounds to use in your productions.",
            },
        };
    },

    methods: {},
};
</script>
