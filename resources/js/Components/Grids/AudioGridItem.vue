<template>
    <div
        :class="
            isAudioPlaying === true
                ? 'bg-secondary-bg-hover'
                : 'bg-secondary-bg'
        "
        class="rounded relative flex-col hover:bg-secondary-bg-hover transition duration-150 ease-in-out"
    >
        <div class="z-10 absolute top-0 right-0 p-3 flex">
            <!-- Info -->
            <span
                class="bg-secondary-bg backdrop-blur-sm text-primary-clr font-semibold text-xs mr-2 p-1 px-3 rounded-full"
                ref="duration"
                >{{ playedTime }}&nbsp;/&nbsp;{{ item.duration_string }}</span
            >
            <button
                v-tooltip="'Show Info'"
                class="bg-secondary-bg backdrop-blur-sm text-primary-clr w-6 h-6 text-white font-semibold text-xs flex justify-center items-center rounded-full hover:bg-secondary-bg-hover"
            >
                <font-awesome-icon icon="info" />
            </button>
        </div>
        <!-- Waveform -->

        <div class="relative h-32 hover:cursor-pointer">
            <wavesurfer
                ref="waveform"
                :src="item.file_url"
                :options="options"
            />
        </div>

        <!-- bottom section -->
        <div class="p-3 bg-secondary-bg backdrop-blur-sm">
            <div
                class="flex flex-wrap overflow-hidden text-brand-clr text-lg justify-between"
            >
                <div class="flex w-7/12 justify-start">
                    <!-- play/pause buttons -->

                    <!-- Play -->
                    <button
                        @click="play"
                        class="text-5xl flex justify-center items-center rounded-full hover:text-brand-clr-hover"
                    >
                        <font-awesome-icon
                            :icon="
                                isAudioPlaying === true
                                    ? 'circle-pause'
                                    : 'circle-play'
                            "
                        />
                    </button>

                    <div
                        class="text-primary-clr mx-4 flex items-center justify-center overflow-hidden"
                    >
                        <span class="truncate">{{ item.name }} </span>
                    </div>
                </div>

                <!-- right action button -->
                <div class="flex items-center w-5/12 justify-end pr-3">
                    <div
                        class="text-secondary-clr rounded-full w-50 whitespace-nowrap"
                    >
                        <!-- Like -->
                        <button
                            @click="toggleLike(2)"
                            v-tooltip="'Like'"
                            class="hover:text-primary-clr"
                        >
                            <font-awesome-icon icon="thumbs-up" />
                        </button>
                        <!-- Share -->
                        <button
                            @click="doCopy('s/' + item.slug)"
                            class="ml-4 hover:text-primary-clr"
                            v-tooltip="'Copy Link'"
                            :showTriggers="(triggers) => [...triggers, 'click']"
                        >
                            <font-awesome-icon icon="link" />
                        </button>
                        <!-- Download -->
                        <button
                            v-tooltip="'Download'"
                            class="ml-4 hover:text-primary-clr"
                        >
                            <font-awesome-icon icon="arrow-down" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { copyText } from "vue3-clipboard";
import { useToast } from "vue-toastification";
import Cursor from "wavesurfer.js/dist/plugin/wavesurfer.cursor";

import { formatTime } from "@/Helpers";

export default {
    props: ["item"],

    data() {
        return {
            options: {
                plugins: [
                    Cursor.create({
                        showTime: true,
                        opacity: 1,
                        color: "#ffca00",

                        customShowTimeStyle: {
                            "background-color": "#ffca00",
                            color: "#121212",
                            padding: "2px",
                            "font-size": "10px",
                        },
                    }),
                ],
                // barWidth: 2,
                // barHeight: 2,
                // barGap: 2,
                // barRadius: 3,
                responsive: true,
                cursorColor: "#ffca00",
                hideScrollbar: true,
                normalize: true,
                height: 128,
                progressColor: "#ffca00",
                waveColor: "rgba(255,255,255,0.05)",
                backgroundColor: "",
            },
            isAudioPlaying: false,
            playedTime: "0:00",
        };
    },

    mounted() {
        const wavesurferRef = this.$refs.waveform.waveSurfer;
        //binding this
        const t = this;

        wavesurferRef.on("seek", function () {
            t.seekPlay();
        });
        wavesurferRef.on("ready", function () {
            let duration = formatTime(wavesurferRef.backend.getDuration());
            console.log(duration);
        });

        wavesurferRef.on("audioprocess", function () {
            t.playedTime = formatTime(wavesurferRef.backend.getCurrentTime());
        });
        wavesurferRef.on("finish", function () {
            wavesurferRef.stop();
            t.isAudioPlaying = false;
            t.playedTime = "0:00";
        });
    },
    setup() {
        // create toast notifications function
        const toast = useToast();

        // Copy url function
        const doCopy = (Url) => {
            copyText(Url, undefined, (error, event) => {
                if (error) {
                    toast(`error -  ${error + " " + event}`);
                } else {
                    // Show toast
                    toast("Copied Sound Url");
                }
            });
        };

        return { doCopy, toast };
    },

    methods: {
        //toggle like for sound

        toggleLike(id) {
            alert(id);
            this.$inertia.post(`/like/${id}`);
        },
        // Wavesurfer controls : Start
        togglePlayPause(value) {
            this.isAudioPlaying = !this.isAudioPlaying;

            if (value) {
                this.showPlay = false;
            } else if (!value) {
                this.showPlay = false;
            }
        },
        play() {
            this.$refs.waveform.waveSurfer.playPause();
            this.isAudioPlaying = this.$refs.waveform.waveSurfer.isPlaying();
        },
        // Seek play when user clicks on waveform play audio
        seekPlay() {
            if (!this.isAudioPlaying) {
                this.$refs.waveform.waveSurfer.play();
                this.isAudioPlaying = true;
            }
        },
        // Wavesurfer controls : End
    },
};
</script>
