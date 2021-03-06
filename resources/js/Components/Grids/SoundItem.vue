<template>
    <div>

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
                                class="text-primary-clr mx-4 flex flex-col items-start justify-center  "
                        >
                            <Link :href="/sound/ + soundItem.id" class="truncate w-full">
                                <span class=" transition-all hover:text-brand-clr"
                                >{{ soundItem.name }}
                                </span>
                            </link>
                            <Link :href="/author/ + soundItem.user_id"
                                  class="text-secondary-clr transition-all hover:text-white text-xs"
                            >By {{ soundItem.creator }}
                            </link>
                        </div>
                    </div>

                    <!-- right action button -->
                    <div class="flex items-center w-5/12 justify-end pr-3">
                        <div v-if="soundItem.edit"
                             class="text-secondary-clr rounded-full w-50 whitespace-nowrap space-x-3">


                            <Link class="hover:bg-blue-500 bg-secondary-bg px-3 py-1 text-sm  text-white rounded-full"
                                  :href="/edit/ + soundItem.id"><span>Edit</span> </Link>
                            <button @click="deleteSound({item:soundItem.id, index:soundItemKey})"
                                    class="hover:bg-red-500  bg-secondary-bg hover:text-white px-3 py-1 text-sm  text-secondary-clr rounded-full"><span>Delete</span></button>

                        </div>

                        <div
                                v-else class="text-secondary-clr rounded-full w-50 whitespace-nowrap"
                        >
                            <!-- Like -->
                            <button
                                    :class="
                                    userHasLiked === true
                                        ? 'text-brand-clr hover:text-brand-clr-hover'
                                        : 'hover:text-primary-clr'
                                "
                                    @click="toggleLike(soundItem.id, soundItem.favoritesPage)"
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
                                    :showTriggers="
                                    (triggers) => [...triggers, 'click']
                                "
                            >
                                <font-awesome-icon icon="link"/>
                            </button>
                            <!-- Download -->
                            <button
                                    @click="
                                    download(soundItem.id, user)
                                "
                                    v-tooltip="'Download'"
                                    class=" cursor-pointer ml-4 hover:text-primary-clr"
                            >
                                <font-awesome-icon icon="arrow-down"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Inertia} from '@inertiajs/inertia'
    import {computed} from 'vue';
    import {copyText} from "vue3-clipboard";
    import {useToast} from "vue-toastification";
    import {usePage} from '@inertiajs/inertia-vue3'
    import Cursor from "wavesurfer.js/dist/plugin/wavesurfer.cursor";
    import {Link} from "@inertiajs/inertia-vue3";

    import {formatTime} from "@/Helpers";

    //Todo  - ScriptProcessorNode is deprecated. Use AudioWorkletNode instead -- wait for wavesurfer update

    //Todo fix to only play one instance at a time  - probably need to pass emit to parent and target non current ref

    //Todo fix record plays

    export default {
        components: {
            Link,
        },
        props: ["soundItem", "soundItemKey"],
        emits: ['deleteSound'],

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
            const user = computed(() => usePage().props.value.auth.user);


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

            return {doCopy, toast, user};
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
            toggleLike(id, favoritesPage) {
                if (this.$page.props.auth.user) {
                    axios
                        .post("/like/" + id)
                        .then(() => {
                            if (favoritesPage === true) {
                                return Inertia.reload({only: ['soundData']})
                            }
                            this.userHasLiked = !this.userHasLiked;
                        })
                        .catch((error) => {
                            console.log(error);
                            this.toast.error(error);
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

                if (user && user.id !== null) {

                    window.location = "/download/" + id;
                } else {
                    this.toast.info("Please login");
                }
            },
            deleteSound(itemToDelete) {
                console.table(itemToDelete);
                this.$emit('deleteSound', itemToDelete)
            }

        }
        ,
    }
    ;
</script>
