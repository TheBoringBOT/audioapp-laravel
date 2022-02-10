<template>
    <div class="bg-slate-200 rounded relative flex-col">
        <!-- Waveform -->
        <div class="relative h-32"></div>
        <!-- buttons -->
        <div class="w-full p-4 bg-white">
            <div class="absolute top-0 right-0 p-3">
                <!-- Info -->
                <button
                    v-tooltip="'Show Info'"
                    class="bg-purple-600 hover:bg-purple-700 p-1 px-3 text-white font-semibold text-xs flex justify-center items-center rounded-full"
                >
                    Info
                </button>
            </div>

            <div
                class="flex align-middle text-purple-600 text-lg justify-between"
            >
                <!-- Play -->
                <button
                    class="text-5xl flex justify-center items-center rounded-full hover:text-purple-700"
                >
                    <font-awesome-icon icon="circle-play" />
                </button>
                <!-- Pause -->
                <button class="text-5xl hidden hover:text-purple-700">
                    <font-awesome-icon icon="circle-pause" />
                </button>
                <div class="bg-purple-50 py-2 px-6 rounded-full w-50">
                    <!-- Like -->
                    <button v-tooltip="'Like'" class="hover:text-purple-700">
                        <font-awesome-icon icon="thumbs-up" />
                    </button>
                    <!-- Share -->
                    <button
                        @click="doCopy('ADD SOUND URL HERE TO BE COPIED')"
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
</template>

<script>
import { copyText } from "vue3-clipboard";
import { useToast } from "vue-toastification";

export default {
    setup() {
        // Get toast interface
        const toast = useToast();

        const doCopy = (Url) => {
            copyText(Url, undefined, (error, event) => {
                if (error) {
                    toast(`error -  ${error}`);
                } else {
                    // Show toast
                    toast("Copied Url");
                }
            });
        };

        return { doCopy, toast };
    },
};
</script>
