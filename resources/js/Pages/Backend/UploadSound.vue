<template>
    <GuestAndUserBackendLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Upload Sound</h2>
        </template>
        <template #content>
            <div class="text-primary bg-primary-bg">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 md:border-r pr-2 border-[#222]">
                        <div class="sm:px-0">
                            <p class="pt-5 text-lg text-primary-clr">
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
                                <div class="py-5 space-y-6">
                                    <!--Name -->
                                    <div>
                                        <div>
                                            <label
                                                for="name"
                                                class="block text-sm font-medium text-primary-clr"
                                            >
                                                Name
                                            </label>
                                            <div
                                                class="mt-1 flex flex-col rounded-md shadow-sm"
                                            >
                                                <input
                                                    v-model="form.name"
                                                    type="text"
                                                    id="name"
                                                    name="name"
                                                    autocomplete="off"
                                                    class="focus:ring-brand-clr text-xl font-semibold focus:border-brand-clr flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-bg bg-secondary-bg"
                                                />
                                                <div
                                                    class="py-5 text-red-500"
                                                    v-if="errors.name"
                                                >
                                                    {{ errors.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label
                                                for="description"
                                                class="block text-sm font-medium text-primary-clr"
                                            >
                                                Description
                                            </label>
                                            <div
                                                class="mt-1 flex flex-col rounded-md shadow-sm"
                                            >
                                                <textarea
                                                    id="description"
                                                    v-model="form.description"
                                                    name="description"
                                                    rows="2"
                                                    maxlength="200"
                                                    class="shadow-sm focus:ring-brand-clr focus:border-brand-clr font-semibold text-xl mt-1 block w-full sm:text-sm border border-gray-300 rounded-md border-secondary-bg bg-secondary-bg"
                                                />

                                                <div
                                                    class="py-5 text-red-500"
                                                    v-if="errors.description"
                                                >
                                                    {{ errors.description }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="multiselect"
                                            class="mb-1 block text-sm font-medium text-primary-clr"
                                        >
                                            Tags
                                        </label>
                                        <!--v-model="tagsSelector.value"-->
                                        <Multiselect
                                            id="multiselect"
                                            class="multiselect-style"
                                            placeholder="Choose or create tag"
                                            :classes="{
                                                tagsSearch:
                                                    'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-secondary-bg rounded',
                                                tagsSearchWrapper:
                                                    'p-0,m-0,focus:border-brand-clr,focus:ring-0',
                                            }"
                                            v-model="form.tags"
                                            v-bind="tagsSelector"
                                        ></Multiselect>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-primary-clr"
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
                                                    class="flex flex-col text-sm text-secondary-clr"
                                                >
                                                    <label
                                                        for="file-upload"
                                                        class="text-2xl relative cursor-pointer bg-secondary-bg text-primary rounded-md font-medium text-primary-clr hover:text-secondary-clr focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 p-2 focus-within:ring-secondary-clr"
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
                                                        class="py-5 text-red-500"
                                                        v-if="errors.sound_file"
                                                    >
                                                        {{ errors.sound_file }}
                                                    </div>

                                                    <p class="pl-1"></p>
                                                </div>
                                                <p
                                                    class="text-xs text-secondary-clr"
                                                >
                                                    MP3, Wav up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3 text-right">
                                    <button
                                        type="submit"
                                        class="inline-flex w-full justify-center py-5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-primary-bg bg-brand-clr hover:bg-brand-clr-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-clr"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                    <div class="border-t border-[#222]" />
                </div>
            </div>
        </template>
    </GuestAndUserBackendLayout>
</template>

<script>
import { useForm, Head } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import GuestAndUserBackendLayout from "@/Components/Layouts/GuestAndUserBackendLayout";

export default {
    components: {
        GuestAndUserBackendLayout,

        Head,
        Multiselect,
    },
    props: ["errors", "allTags"],

    data(props) {
        return {
            tagsSelector: {
                mode: "tags",
                value: [""],
                closeOnSelect: false,
                options: props.allTags,
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
            tags: [],
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

<!-- Using the `scoped` attribute -->
<style scoped>
.multiselect-style {
    --ms-tag-bg: dodgerblue;
    --ms-bg: rgba(255, 255, 255, 0.05);
    --ms-dropdown-bg: rgb(30, 30, 34);
    --ms-border-color: rgba(255, 255, 255, 0.05);
    --ms-tag-color: #fff;
    --ms-group-label-bg: #e5e7eb;
    --ms-tag-radius: 9999px;
    --ms-tag-font-weight: 400;
    --ms-search-wrapper-bg: #222;
}
</style>
