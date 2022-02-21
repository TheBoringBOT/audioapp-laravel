<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>

    <LoggedOutLayout class="text-primary-clr">
        <ContentContainer>
            <nav class="rounded-md w-full">
                <ol class="list-reset flex">
                    <li>
                        <Link
                            href="/"
                            class="font-semibold text-brand-clr hover:text-brand-clr-hover transition duration-150 ease-in-out"
                            >Home</Link
                        >
                    </li>
                    <li>
                        <span class="font-semibold text-secondary-clr mx-2"
                            >/</span
                        >
                    </li>
                    <li>
                        <Link
                            :href="/sound/ + soundData.id"
                            class="text-secondary-clr pointer-events-none"
                            >Sound - {{ soundData.name }}</Link
                        >
                    </li>
                </ol>
            </nav>
            <div
                class="pt-3 grid gap-0 md:gap-5 grid-cols-1 md:grid-cols-6 xl:grid-cols-5"
            >
                <div class="col-span-4">
                    <!-- soundData item -->
                    <SoundItem
                        :soundItem="soundData"
                        :key="soundData.id"
                        :soundItemKey="soundData.id"
                        :currentUserData="currentUserData"
                    />
                    <!-- Description -->
                    <div class="py-5">
                        <h2 class="text-xl py-3">Description:</h2>
                        <span class="text-lg">{{ soundData.description }}</span>
                    </div>
                    <!-- Tags -->
                    <div class="mt-4">
                        <span class="mr-3 text-primary-clr font-semibold"
                            >Tags:</span
                        >
                        <Link
                            :href="`/search` + '?' + `keyword=${tag}`"
                            class="text-primary-clr font-semibold bg-secondary-bg hover:bg-secondary-bg-hover transition duration-150 ease-in-out px-3 py-2 mr-3 rounded"
                            v-for="tag in tags"
                            :key="tag.id"
                            >{{ tag }}</Link
                        >
                    </div>
                </div>
                <div
                    class="mt-12 md:mt-0 col-span-2 xl:col-span-1 w-full flex grow"
                >
                    <div
                        class="border border-secondary-bg xl:text-lg flex grow flex-col p-5 bg-secondary-bg justify-between"
                    >
                        <div>
                            <div class="flex justify-between">
                                <span>Bit Depth:</span>
                                <span class="text-secondary-clr"
                                    >{{ soundData.bit_depth }} bit</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span>Sample Rate:</span>
                                <span class="text-secondary-clr">{{
                                    soundData.sample_rate
                                }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span>Likes:</span>
                                <span class="text-secondary-clr">{{
                                    likes
                                }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Plays:</span>
                                <span class="text-secondary-clr">{{
                                    soundData.plays
                                }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Downloads:</span>
                                <span class="text-secondary-clr">{{
                                    soundData.downloads
                                }}</span>
                            </div>
                        </div>
                        <div class="mt-4 lg:mt-0">
                            <button
                                @click="
                                    download(
                                        soundData.id,
                                        $page.props.auth.user
                                    )
                                "
                                class="text-base w-full block font-semibold text-primary-bg px-6 py-2 bg-brand-clr hover:bg-brand-clr-hover hover:border-0 rounded"
                            >
                                Download Sound
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </ContentContainer>
    </LoggedOutLayout>
</template>

<script>
import LoggedOutLayout from "@/Components/Layouts/LoggedOutLayout.vue";
import ContentContainer from "@/Components/Layouts/ContentContainer";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import SoundItem from "@/Components/Grids/SoundItem";

export default {
    components: {
        Head,
        Link,
        LoggedOutLayout,
        ContentContainer,
        SoundItem,
    },
    props: ["soundData", "tags", "likes", "currentUserData"],
    data(props) {
        return {
            seo: {
                title: "sound" + "-" + props.soundData.name,
                description: props.soundData.description,
            },
        };
    },

    setup() {
        const toast = useToast();
        return { toast };
    },

    methods: {
        download(id, user) {
            //must pass sound id +  $page.props.auth

            if (user) {
                window.location = "/download/" + id;
            } else {
                this.toast.info("Please login");
            }
        },
    },
};
</script>
