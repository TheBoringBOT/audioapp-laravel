<template>
    <StaggeredFade
        :duration="100"
        tag="div"
        class="py-3 grid gap-5 grid-cols-1 md:grid-cols-2 xl:grid-cols-3"
    >
        <AudioItem
            class="transition-transform duration-300 translate-y-24"
            v-for="(sound, key) in soundData"
            :soundItem="sound"
            :data-index="key"
            :key="key"
            :soundItemKey="key"
        />
    </StaggeredFade>
</template>

<script>
import AudioItem from "./SoundItem";
import StaggeredFade from "@/Components/Animations/StaggeredFade";

//TODO: fix count plays function
export default {
    props: ["soundData"],
    data() {
        return {
            played: [],
        };
    },

    components: {
        AudioItem,
        StaggeredFade,
    },
    methods: {
        playedTrack(value) {
            if (this.played.indexOf(value) === -1) {
                this.played.push(value);
            }
        },
        getDelay(key) {
            return "animation-delay:" + key * 1000;
        },
    },
};
</script>

<style scoped>
/* we will explain what these classes do next! */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0px);
    }
}

.fadeIn {
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
    animation-duration: 1s;
}
</style>
