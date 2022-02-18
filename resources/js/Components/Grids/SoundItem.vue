<template>
    <div
            :class="isAudioPlaying === true ? 'bg-secondary-bg' : ''"
            class="border border-secondary-bg rounded relative flex-col hover:bg-secondary-bg-hover transition duration-150 ease-in-out"
    >
        <div class="z-10 absolute top-0 right-0 p-3 flex">
            <span
                    class="bg-secondary-bg backdrop-blur-sm text-primary-clr font-semibold text-xs mr-2 p-1 px-3 rounded-full"
                    ref="duration"
            >{{ playedTime }}&nbsp;/&nbsp;{{
                    soundItem.duration_string
                }}</span
            >
            <!-- Info -->
            <Link
                    :href="/sound/ + soundItem.id"
                    v-tooltip="'Show Info'"
                    class="bg-secondary-bg backdrop-blur-sm text-primary-clr w-6 h-6 font-semibold text-xs flex justify-center items-center rounded-full hover:bg-secondary-bg-hover"
            >
                <font-awesome-icon icon="info"/>
            </Link>
        </div>
        <!-- Waveform -->

        <div class="relative h-24 hover:cursor-pointer">
            <wavesurfer
                    :data-playing="isAudioPlaying === true ? '1' : '0'"
                    :ref="'waveform' + soundItemKey"
                    :src="soundItem.file_url"
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
                            @click="[playPause(), count++]"
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
                            class="text-primary-clr mx-4 flex flex-col items-start justify-center overflow-hidden"
                    >
                        <Link :href="/sound/ + soundItem.id">
                            <span class="truncate">{{ soundItem.name }} </span>
                        </Link>
                        <span class="text-secondary-clr text-xs"
                        >By {{ soundItem.creator }}</span
                        >
                    </div>
                </div>

                <!-- right action button -->
                <div class="flex items-center w-5/12 justify-end pr-3">
                    <div
                            class="text-secondary-clr rounded-full w-50 whitespace-nowrap"
                    >
                        <!-- Like -->
                        <button
                                :class="
                                userHasLiked === true
                                    ? 'text-brand-clr hover:text-brand-clr-hover'
                                    : 'hover:text-primary-clr'
                            "
                                @click="toggleLike(soundItem.id)"
                                v-tooltip="'Like'"
                                class="transition duration-150"
                        >
                            <font-awesome-icon icon="thumbs-up"/>
                        </button>
                        <!-- Share -->
                        <button
                                @click="doCopy(soundUrl + soundItem.id)"
                                class="ml-4 hover:text-primary-clr"
                                v-tooltip="'Copy Link'"
                                :showTriggers="(triggers) => [...triggers, 'click']"
                        >
                            <font-awesome-icon icon="link"/>
                        </button>
                        <!-- Download -->
                        <a
                                @click="download(soundItem.id, $page.props.auth)"
                                v-tooltip="'Download'"
                                class="ml-4 hover:text-primary-clr"
                        >
                            <font-awesome-icon icon="arrow-down"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {copyText} from "vue3-clipboard";
import {useToast} from "vue-toastification";
import Cursor from "wavesurfer.js/dist/plugin/wavesurfer.cursor";
import {Link} from "@inertiajs/inertia-vue3";
import _ from "lodash";

import {formatTime} from "@/Helpers";

//Todo  - ScriptProcessorNode is deprecated. Use AudioWorkletNode instead -- wait for wavesurfer update

//Todo fix to only play one instance at a time  - probably need to pass emit to parent and target non current ref

//Todo fix record plays
//Todo fix upvote sound
export default {
    components: {
        Link,
    },
    props: ["soundItem", "soundItemKey"],

    //Destroy wavesurfer on unmount
    //TODO fade out sound before destroying
    beforeUnmount() {
        if (this.isAudioPlaying === true) {
            this.destroyWaveSurfer();
        }
    },

    data(props) {
        return {
            soundUrl: location.host + "/sound/",
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

                responsive: true,
                cursorColor: "#ffca00",
                hideScrollbar: true,
                normalize: true,
                height: 96,
                progressColor: "#ffca00",
                waveColor: "rgba(255,255,255,0.05)",
                backgroundColor: "",
            },
            isAudioPlaying: false,
            currentSoundId: undefined,
            playRecorded: false,
            playedTime: "0:00",
            count: 0,
            userHasLiked: props.soundItem.liked,
        };
    },

    mounted() {
        //binding this
        const t = this;
        const wavesurferRef = this.$refs["waveform" + t.soundItemKey]
            .waveSurfer;

        wavesurferRef.on("seek", function () {
            t.seekPlay(t.soundItemKey);
        });

        wavesurferRef.on("audioprocess", function () {
            t.playedTime = formatTime(wavesurferRef.backend.getCurrentTime());
        });
        wavesurferRef.on("finish", function () {
            t.resetWaveSurfer();
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

        return {doCopy, toast};
    },

    methods: {
        // Wavesurfer controles

        playPause() {
            if (!this.isAudioPlaying) {
                this.$refs["waveform" + this.soundItemKey].waveSurfer.play();

                this.isAudioPlaying = !this.isAudioPlaying;
            } else if (this.isAudioPlaying) {
                this.$refs["waveform" + this.soundItemKey].waveSurfer.pause();

                this.isAudioPlaying = !this.isAudioPlaying;
            }
        },
        // Seek play when user clicks on waveform play audio
        seekPlay() {
            if (!this.isAudioPlaying) {
                this.$refs["waveform" + this.soundItemKey].waveSurfer.play();
                this.isAudioPlaying = !this.isAudioPlaying;
            }
        },
        resetWaveSurfer() {
            this.$refs["waveform" + this.soundItemKey].waveSurfer.stop();
            this.isAudioPlaying = false;
            this.playedTime = "0:00";
        },
        destroyWaveSurfer() {
            this.$refs["waveform" + this.soundItemKey].waveSurfer.destroy();
        },
        // Wavesurfer controls : End
        //toggle like for sound
        toggleLike(id) {
            if (this.$page.props.auth) {
                axios
                    .post("/like/" + id)
                    .then(() => {
                        this.userHasLiked = !this.userHasLiked;
                    })
                    .catch((error) => {
                        this.toast.error("Error, please try again");
                    });
            } else {
                this.toast.info("Please login");
            }
        },

        updatePlays(id) {
            // return "ran" + " " + id;
            // this.$inertia.post(`/play/${id}`);
        },
        download(id, user) {
            //must pass sound id +  $page.props.auth
            if (user.id) {
                window.location = "/download/" + id;
            } else {
                this.toast.info("Please login");
            }
        },
    },
};
</script>
