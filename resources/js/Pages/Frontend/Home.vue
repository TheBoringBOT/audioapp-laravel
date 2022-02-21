<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>
    <LoggedOutLayout class="bg-white">
        <ContentContainer>
            <div class="relative">
                <div
                    class="md:grid lg:grid-flow-row-dense md:grid-cols-2 md:gap-12"
                >
                    <div
                        class="lg:col-start-1 flex flex-col h-100 items-start grow justify-center"
                    >
                        <h1
                            class="lg:text-6xl font-extrabold text-primary-clr text-4xl"
                        >
                            High Quality Sounds <br />& FX
                        </h1>
                        <Link
                            class="mt-6 font-semibold text-primary-bg px-7 py-3 bg-brand-clr hover:bg-brand-clr-hover hover:border-0 rounded"
                            href="/sounds"
                        >
                            Discover Now
                        </Link>
                    </div>
                    <div
                        class="mt-10 relative col-span-full lg:mt-0 md:col-start-2 justify-end md:ml-[5vw] min-h-[70vh] bg-cover bg-no-repeat bg-[url('/images/home.jpg')]"
                    ></div>
                </div>
            </div>

            <!-- Notify -->
            <div
                class="mt-20 px-6 py-6 bg-secondary-bg rounded-lg md:py-12 md:px-12 lg:py-16 lg:px-16 xl:flex xl:items-center"
            >
                <div class="xl:w-0 xl:flex-1">
                    <h2
                        class="text-2xl leading-8 font-extrabold tracking-tight text-white sm:text-3xl sm:leading-9"
                    >
                        Receive alerts about new sounds or news about this site.
                    </h2>
                    <p
                        class="mt-3 max-w-3xl text-lg leading-6 text-secondary-clr"
                    >
                        We use push notifications. You can choose between
                        several modes and define your own alert threshold.
                    </p>
                </div>
                <div class="mt-8 sm:w-full sm:max-w-md xl:mt-0 xl:ml-8">
                    <div
                        class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0"
                    >
                        <button
                            @click="
                                () => this.toast.info('Not working in demo app')
                            "
                            class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white border-2 border-brand-clr text-brand-clr hover:bg-brand-clr hover:text-primary-bg transition duration-150 ease-in-out"
                        >
                            Notify me
                        </button>
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

export default {
    components: {
        Head,
        Link,
        LoggedOutLayout,

        ContentContainer,
    },
    props: ["keyword", "popularTags"],
    data() {
        return {
            seo: {
                title: "A Sounds App",
                description: "An app build with Laravel, Vue3, Interia, MySql",
            },
        };
    },

    setup() {
        // create toast notifications function
        const toast = useToast();
        return { toast };
    },
};
</script>
