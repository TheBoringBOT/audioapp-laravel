<template>
    <Head title="Home" />
    <LoggedOutLayout>
        <!--<h1>Home {{ $inertia.page.props.appName }}</h1>-->

        <!--<div>-->
        <!--<h4><code>av-waveform</code> component</h4>-->

        <!--<av-waveform-->
        <!--:playtime-line-width="2.8"-->
        <!--audio-src="/uploads/1/sounds/1.wav"-->
        <!--&gt;</av-waveform>-->
        <!--</div>-->

        <SearchBar />
        <AudioGrid />
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
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
};
</script>
