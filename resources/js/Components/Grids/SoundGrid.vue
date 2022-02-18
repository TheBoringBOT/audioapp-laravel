<template>
    <div class="py-3 grid gap-5 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <AudioItem
            v-for="(sound, key) in soundData"
            :soundItem="sound"
            :key="key"
            :soundItemKey="key"
        />
    </div>

    <h1 class="text-white">{{ played }}</h1>
</template>

<script>
import AudioItem from "./SoundItem";

export default {
    props: ["soundData"],
    data() {
        return {
            played: [],
        };
    },

    components: {
        AudioItem,
    },
    methods: {
        playedTrack(value) {
            if (this.played.indexOf(value) === -1) {
                this.played.push(value);
            }
        },
    },
};
</script>
