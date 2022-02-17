<template>
    <div class="mb-6 flex flex-col w-full items-center">
        <div class="flex border-0 bg-secondary-bg max-w-xl">
            <input
                v-on:keyup.enter="searchSounds"
                v-model="keyword"
                type="text"
                class="capitalize text-primary-clr border-0 bg-secondary-bg py-2 w-full"
                placeholder="Search by name or tag.."
            />
            <button
                @click="searchSounds"
                class="font-semibold w-80 px-4 text-primary-bg bg-brand-clr hover:bg-brand-clr-hover"
            >
                Search
            </button>
        </div>
        <!-- Popular Tags -->
        <PopularTags :currentTag="keyword" :popularTags="popularTags" />
    </div>
</template>

<script>
import PopularTags from "@/Components/PopularTags";

export default {
    props: ["keyword", "currentUserData", "popularTags"],
    components: {
        PopularTags,
    },

    methods: {
        searchSounds() {
            this.$inertia.get("search", { keyword: this.keyword });
        },
    },
};
</script>
