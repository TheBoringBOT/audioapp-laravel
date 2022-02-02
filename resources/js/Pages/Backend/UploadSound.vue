<template>
    <BreezeAuthenticatedLayout>
        <template #header>
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Upload Sound
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Upload your sound with the required data and the
                                rest will be taken from the audio Metadata.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form
                            @submit.prevent="submit"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            <div
                                class="shadow sm:rounded-md sm:overflow-hidden"
                            >
                                <div
                                    class="px-4 py-5 bg-white space-y-6 sm:p-6"
                                >
                                    <!--Name -->
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label
                                                for="name"
                                                class="block text-sm font-medium text-gray-700"
                                            >
                                                Name
                                            </label>
                                            <div
                                                class="mt-1 flex rounded-md shadow-sm"
                                            >
                                                <input
                                                    v-model="form.name"
                                                    type="text"
                                                    id="name"
                                                    name="name"
                                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                                />
                                                <div v-if="errors.name">
                                                    {{ errors.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label
                                                for="description"
                                                class="block text-sm font-medium text-gray-700"
                                            >
                                                Description
                                            </label>
                                            <div
                                                class="mt-1 flex rounded-md shadow-sm"
                                            >
                                                <textarea
                                                    id="description"
                                                    v-model="form.description"
                                                    name="description"
                                                    rows="2"
                                                    maxlength="200"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                                />

                                                <div v-if="errors.description">
                                                    {{ errors.description }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="multiselect"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Choose or create Tags
                                        </label>
                                        <Multiselect
                                            id="multiselect"
                                            v-model="tagsSelector.value"
                                            v-bind="tagsSelector"
                                        ></Multiselect>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Add Wav or MP3 file
                                        </label>
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                        >
                                            <div class="space-y-1 text-center">
                                                <svg
                                                    class="mx-auto h-12 w-12 text-gray-400"
                                                    stroke="currentColor"
                                                    fill="none"
                                                    viewBox="0 0 48 48"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                                <div
                                                    class="flex text-sm text-gray-600"
                                                >
                                                    <label
                                                        for="file-upload"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                                    >
                                                        <span
                                                            >Upload a file</span
                                                        >
                                                        <input
                                                            @input="
                                                                form.sound_file =
                                                                    $event.target.files[0]
                                                            "
                                                            id="file-upload"
                                                            name="file-upload"
                                                            type="file"
                                                            class="sr-only"
                                                        />
                                                    </label>
                                                    <div
                                                        v-if="errors.sound_file"
                                                    >
                                                        {{ errors.sound_file }}
                                                    </div>

                                                    <p class="pl-1">
                                                        or drag and drop
                                                    </p>
                                                </div>
                                                <p
                                                    class="text-xs text-gray-500"
                                                >
                                                    MP3, Wav up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                    <div class="border-t border-gray-200" />
                </div>
            </div>
        </template>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "../../Components/Layouts/Authenticated";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Multiselect,
    },
    props: {
        errors: Object,
    },

    data() {
        return {
            tagsSelector: {
                mode: "tags",
                value: [""],
                closeOnSelect: false,

                //Todo get tags from DB + create function if new ones added
                options: [
                    { value: "batman", label: "Batman" },
                    { value: "robin", label: "Robin" },
                    { value: "joker", label: "Joker" },
                ],
                searchable: true,
                createOption: true,
            },
        };
    },

    setup() {
        const form = useForm({
            name: null,
            description: null,
            sound_file: null,
            // bit_rate: null,
            // bit_depth: null,
            // duration: null,
        });

        function submit() {
            form.post("/dashboard/upload");
        }

        return { form, submit };
    },
};
</script>

<!--Styles for multiselect -->
<style src="@vueform/multiselect/themes/default.css"></style>
