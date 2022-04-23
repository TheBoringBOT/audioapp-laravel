<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>
    <GuestAndUserFrontendLayout>
        <ContentContainer>
            <div
                class="site-main__wrap mx-auto max-w-screen-2xl flex-grow flex flex-col"
            >
                <div class="mx-auto w-full max-w-screen-2xl lg:pt-6">
                    <div class="text-center">
                        <h1 class="mt-12 text-primary-clr">
                            <span class="text-3xl md:text-5xl font-bold">
                                About
                            </span>
                        </h1>
                    </div>
                    <div
                        class="bg-secondary-bg shadow rounded max-w-screen-xl mx-auto mt-14 text-center"
                    >
                        <div
                            class="max-w-screen-lg mx-auto px-4 sm:px-6 md:px-12 py-6 sm:py-8 md:py-16"
                        >
                            <div
                                class="text-primary-clr prose sm:prose-lg md:prose-xl max-w-none"
                            >
                                <h1
                                    class="py-5 text-2xl md:text-6xl text-brand-clr font-semibold"
                                >
                                    An audio sharing app.
                                </h1>

                                <p class="text-xl md:text-2xl">
                                    This audio application was built as a proof
                                    of concept for a royalty free audio company.
                                    <br />
                                    It's now open source and possible to use for
                                    your own purpose. <br />
                                    <br />
                                    It's a great starting point to build your
                                    own audio sharing website or store.
                                </p>
                                <hr
                                    class="border-secondary-bg w-1/2 mx-auto my-10"
                                />

                                <div class="flex justify-center mt-8">
                                    <a
                                        class="justify-center rounded items-center max-w-[200px] bg-secondary-bg fill-primary-clr hover:fill-secondary-clr hover:text-secondary-clr transition duration-150 ease-in-out text-center flex p-3 flex align-center"
                                        href="https://github.com/TheBoringBOT/audioapp-laravel"
                                        ><svg
                                            class=""
                                            height="28"
                                            aria-hidden="true"
                                            viewBox="0 0 16 16"
                                            version="1.1"
                                            width="28"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"
                                            ></path></svg
                                        ><span class="ml-3"
                                            >view on github</span
                                        ></a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </ContentContainer>
    </GuestAndUserFrontendLayout>
</template>

<script>
import LoggedOutLayout from "@/Components/Layouts/LoggedOutLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ContentContainer from "@/Components/Layouts/ContentContainer";
import GuestAndUserFrontendLayout from "@/Components/Layouts/GuestAndUserFrontendLayout";

export default {
    components: {
        GuestAndUserFrontendLayout,
        Head,
        Link,
        LoggedOutLayout,
        ContentContainer,
    },
    data() {
        return {
            seo: {
                title: "About this audio sharing app",
                description:
                    "This audio application was built as a proof of concept for a royalty free audio company. Download the code on Github",
            },
        };
    },

    methods: {},
};
</script>
