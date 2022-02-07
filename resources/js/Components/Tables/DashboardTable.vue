<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex flex-col">

        <audio
                src="https://file-examples-com.github.io/uploads/2017/11/file_example_MP3_700KB.mp3"
                ref="audioPlayer"
                @timeupdate="onPlaying"
        >
    Your browser does not support the
    <code>audio</code> element.
  </audio>
        <button v-bind:class="[isActive ? 'red' : 'blue']" @click="toggleClass()"


                @click.prevent="
                playSound(
                    'http://soundbible.com/mp3/Air Plane Ding-SoundBible.com-496729130.mp3'
                )
            "
        >
            play
        </button>
        <button @click.prevent="stopSound()">Stop</button>
        <audio
                src="https://file-examples-com.github.io/uploads/2017/11/file_example_MP3_700KB.mp3"
                ref="audioPlayer"
                @timeupdate="onPlaying"
        >
            Your browser does not support the
            <code>audio</code> element.
        </audio>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                    class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
                <div
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Name
                                </th>
                                <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Title
                                </th>
                                <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Role
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="track in audio" :key="track.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                                class="flex-shrink-0 h-10 w-10"
                                        ></div>
                                        <div class="ml-4">
                                            <div
                                                    class="text-sm font-medium text-gray-900"
                                            >
                                                {{ track.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ track.description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ track.duration }}
                                    </div>
                                    <!--<div class="text-sm text-gray-500">{{ person.department }}</div>-->
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                                    >
                                        Active
                                    </span>
                                </td>
                                <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ track.bit_depth }}
                                </td>
                                <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                >
                                    <a
                                            href="#"
                                            class="text-indigo-600 hover:text-indigo-900"
                                    >Edit</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["audio"],

    data() {
        return {
            isActive: false,
        };
    },
    methods: {
        play(sound) {
            alert("play");
            sound.play();
        },
        playSound(sound) {
            if (sound) {
                var audio = new Audio(sound);
                audio.play();

            }
        },
        stopSound(audio) {
            if (audio) {
                Audio().stop();
            }
        },
        toggleClass: function (event) {
            this.isActive = !this.isActive;
        }
    },
    setup() {
    },
};
</script>
