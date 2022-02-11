<template>
    <Head title="Home" />
    <LoggedOutLayout>
        <SearchBar />
        <AudioGrid v-bind:audio="audio" />
    </LoggedOutLayout>
</template>

<script>
import LoggedOutLayout from "@/Components/Layouts/LoggedOutLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

import SearchBar from "@/Components/SearchBar";
import AudioGrid from "@/Components/Grids/AudioGrid";

export default {
    components: {
        Head,
        Link,
        LoggedOutLayout,
        AudioGrid,
        SearchBar,
    },
    props: ["audio"],
};
</script>