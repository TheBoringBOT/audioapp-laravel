<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description"/>
    </Head>
    <LoggedOutLayout>
        <ContentContainer>
            <SearchBar :popularTags="popularTags" v-bind:keyword="keyword"/>
            <div v-if="soundData.length">
                <SoundGrid
                        :currentUserData="currentUserData"
                        :soundData="soundData"
                />
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
    </LoggedOutLayout>
</template>

<script>
import LoggedOutLayout from "@/Components/Layouts/LoggedOutLayout.vue";
import ContentContainer from "@/Components/Layouts/ContentContainer";
import {Head, Link} from "@inertiajs/inertia-vue3";

import SearchBar from "@/Components/SearchBar";
import SoundGrid from "@/Components/Grids/SoundGrid";

export default {
    components: {
        Head,
        Link,
        LoggedOutLayout,
        SoundGrid,
        SearchBar,
        ContentContainer,
    },
    props: ["soundData", "keyword", "currentUserData", "popularTags"],
    data() {
        return {
            seo: {
                title: "A Sounds App",
                description: "An app build with Laravel, Vue3, Interia, MySql",
            },
        };
    },

    methods: {},
};
</script>
