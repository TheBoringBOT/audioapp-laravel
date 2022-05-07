<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>

    <GuestAndUserFrontendLayout>
        <!--background for hero-->

        <div class="flex flex-col z-2 relative bg-author-bg">
            <ContentContainer>
                <div class="py-5">
                    <!-- image -->
                    <div class="flex items-center justify-center relative">
                        <figure
                            class="rounded-full bg-secondary-bg w-28 h-28 md:w-32 md:h-32 block mb-2 md:mb-4 overflow-visible relative"
                        >
                            <img
                                :src="author.avatar"
                                alt="author.name"
                                class="rounded-full flex items-center justify-center w-full h-full relative z-[1]"
                            />
                            <!--blur image-->
                            <img
                                :src="author.avatar"
                                alt="author.name"
                                class="pulse rounded-full w-full h-full blur-xl absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 opacity-50"
                            />
                        </figure>
                    </div>
                    <!-- text-->
                    <div
                        class="flex flex-col items-center justify-center space-x-5"
                    >
                        <span class="text-brand-clr font-medium">Author</span>
                        <h1
                            class="font-semibold text-white text-4xl md:text-5xl"
                        >
                            {{ author.name }}
                        </h1>
                        <p
                            class="font-medium text-secondary-clr md:text-lg mt-2 md:mt-2 max-w-[600px] text-center"
                        >
                            {{ author.description }}
                        </p>
                    </div>
                </div>
            </ContentContainer>
        </div>

        <ContentContainer class="pt-5">
            <div v-if="soundData.length" class="mb-16">
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

<style scoped>
@-webkit-keyframes pulse {
    0% {
        -webkit-transform: scale(1);
    }
    50% {
        -webkit-transform: scale(1.05);
    }
    100% {
        -webkit-transform: scale(1);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.pulse {
    -webkit-animation-name: pulse;
    animation-name: pulse;
    animation: pulse 4s infinite;
    left: 0;
    top: 0;
}
</style>
