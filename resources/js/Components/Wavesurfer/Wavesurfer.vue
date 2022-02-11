<template>
    <wavesurfer ref="waveform" :src="item.file_url" :options="options"/>
</template>
<script>
export default {
    props: ["item"],
    emits: ["audio-is-playing", "audio-duration"],
    data() {
        return {
            options: {
                barWidth: 3,
                barHeight: 1,
                barGap: null,
                progressColor: "green",
                waveColor: "pink",
            },
        };
    },
    methods: {
        play() {
            this.$refs.waveform.waveSurfer.playPause();
            let audioIsPlaying = this.$refs.waveform.waveSurfer.isPlaying();
            // send if audio is playing to parent
            this.$emit("audio-is-playing", audioIsPlaying);

            this.$emit(
                "audio-duration",
                this.$refs.waveform.waveSurfer.getDuration()
            );
        },
    },
};
</script>
