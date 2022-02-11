<template>
    <div class="bg-slate-200 rounded relative flex-col">
        <div class="z-10 absolute top-0 right-0 p-3 flex">
            <!-- Info -->
            <span
                class="bg-purple-600 text-white font-semibold text-xs mr-2 p-1 px-3 rounded-full text-gray-500"
                ref="duration"
                >{{ playedTime }}&nbsp;/&nbsp;{{ item.duration_string }}</span
            >
            <button
                v-tooltip="'Show Info'"
                class="bg-purple-600 hover:bg-purple-700 w-6 h-6 text-white font-semibold text-xs flex justify-center items-center rounded-full"
            >
                <font-awesome-icon icon="info" />
            </button>
        </div>
        <!-- Waveform -->

        <div class="relative h-32">
            <wavesurfer
                ref="waveform"
                :src="item.file_url"
                :options="options"
            />
        </div>

        <!-- bottom section -->
        <div class="p-4 bg-white">
            <div
                class="flex flex-wrap overflow-hidden text-purple-600 text-lg justify-between"
            >
                <div class="flex w-7/12 justify-start">
                    <!-- play/pause buttons -->

                    <!-- Play -->
                    <button
                        @click="play"
                        class="text-5xl flex justify-center items-center rounded-full hover:text-purple-700"
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
                        class="mx-4 flex items-center justify-center overflow-hidden"
                    >
                        <span class="truncate">{{ item.name }} </span>
                    </div>
                </div>

                <!-- right action button -->
                <div class="flex w-5/12 justify-end">
                    <div
                        class="bg-purple-50 py-2 px-6 rounded-full w-50 whitespace-nowrap"
                    >
                        <!-- Like -->
                        <button
                            @click="toggleLike(2)"
                            v-tooltip="'Like'"
                            class="hover:text-purple-700"
                        >
                            <font-awesome-icon icon="thumbs-up" />
                        </button>
                        <!-- Share -->
                        <button
                            @click="doCopy('s/' + item.slug)"
                            class="ml-4 hover:text-purple-700"
                            v-tooltip="'Copy Link'"
                            :showTriggers="(triggers) => [...triggers, 'click']"
                        >
                            <font-awesome-icon icon="link" />
                        </button>
                        <!-- Download -->
                        <button
                            v-tooltip="'Download'"
                            class="ml-4 hover:text-purple-700"
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
import WaveSurfer from "@/Components/Wavesurfer/Wavesurfer";
import { formatTime } from "@/Helpers";

export default {
    components: {
        WaveSurfer,
    },
    props: ["item"],

    data() {
        return {
            options: {
                barWidth: 2,
                barHeight: 2,
                barGap: 2,
                barRadius: 3,
                cursorColor: "#7E22CE",
                hideScrollbar: true,
                normalize: true,
                height: 128,
                progressColor: "#7E22CE",
                waveColor: "#b1b7be",
                backgroundColor: "#cfd5dc",
            },
            isAudioPlaying: false,
            playedTime: "0:00",
        };
    },

    mounted() {
        const wavesurferRef = this.$refs.waveform.waveSurfer;
        //binding this
        const t = this;
        wavesurferRef.on("ready", function () {
            let duration = formatTime(wavesurferRef.backend.getDuration());
            console.log(duration);
        });

        wavesurferRef.on("audioprocess", function () {
            t.playedTime = formatTime(wavesurferRef.backend.getCurrentTime());
        });
        wavesurferRef.on("finish", function () {
            //toggle play/pause buttons
            t.togglePlayPause(false);
            // reset waveform to start
            wavesurferRef.seekAndCenter(0);
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
        // Wavesurfer controls : End
    },
};
</script>
