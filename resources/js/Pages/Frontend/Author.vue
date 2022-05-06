<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>

    <GuestAndUserFrontendLayout>
        <!--background for hero-->
        <div
            class="z-1 w-full h-full absolute left-0 top-0 bg-author-bg max-h-[55vh] min-h-[640px]"
        ></div>
        <ContentContainer>
            <div
                class="max-h-[55vh] min-h-[500px] flex flex-col pt-10 z-2 relative"
            >
                <!-- image -->
                <div class="flex items-center justify-center relative">
                    <img
                        :src="author.avatar"
                        alt=""
                        class="rounded-full flex items-center justify-center w-48 h-48 mb-12 relative z-[1]"
                    />
                    <!--blur image-->
                    <img
                        :src="author.avatar"
                        alt=""
                        class="rounded-full w-48 h-48 blur-xl absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 opacity-50"
                    />
                </div>
                <!-- text-->
                <div
                    class="flex flex-col items-center justify-center space-x-5"
                >
                    <span class="text-brand-clr font-medium">Author</span>
                    <h1 class="font-semibold text-white text-5xl">
                        {{ author.name }}
                    </h1>
                    <p
                        class="font-medium text-secondary-clr text-xl mt-5 max-w-[600px] text-center"
                    >
                        {{ author.description }}
                    </p>
                </div>
            </div>

            <div v-if="soundData.length" class="my-16">
                <SoundGrid :soundData="soundData" />
            </div>
        </ContentContainer>
    </GuestAndUserFrontendLayout>
</template>

<script>
import GuestAndUserFrontendLayout from "@/Components/Layouts/GuestAndUserFrontendLayout.vue";
import ContentContainer from "@/Components/Layouts/ContentContainer";
import { Head, Link } from "@inertiajs/inertia-vue3";

import SoundGrid from "@/Components/Grids/SoundGrid";

export default {
    components: {
        Head,
        Link,
        GuestAndUserFrontendLayout,
        SoundGrid,

        ContentContainer,
    },
    props: ["soundData", "author"],
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
