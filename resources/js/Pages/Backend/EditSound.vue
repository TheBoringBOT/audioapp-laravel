<template>
    <GuestAndUserBackendLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Edit Sound {{ sound.name }}
            </h2>
        </template>
        <template #content>
            <div class="text-white bg-primary-bg font-semibold">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 md:border-r pr-2 border-[#222]">
                        <div class="sm:px-0">
                            <p class="pt-5 text-lg text-primary-clr">
                                Edit your sound.
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
                                                    class="block text-primary-clr"
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
                                                        class="rounded focus:ring-brand-clr font-semibold focus:border-brand-clr flex-1 block w-full border-secondary-bg bg-secondary-bg"
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
                                                    class="block text-primary-clr"
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
                                                        rows="4"
                                                        maxlength="200"
                                                        class="resize-none shadow-sm focus:ring-brand-clr focus:border-brand-clr text-xl mt-1 block w-full border border-gray-300 rounded-md border-secondary-bg bg-secondary-bg"
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
                                                class="mb-1 block text-primary-clr"
                                        >
                                            Tags
                                        </label>
                                        <!--v-model="tagsSelector.value"-->

                                        <Multiselect
                                                :object="true"
                                                v-model="form.tags"
                                                :modelValue="
                                                tags.map((item) => ({
                                                    value: item,
                                                }))
                                            "
                                                id="multiselect"
                                                class="multiselect-style"
                                                placeholder="Choose or create tag"
                                                v-bind="tagsSelector"
                                        ></Multiselect>
                                    </div>

                                    <div>
                                        <label
                                                class="block text-lg font-medium text-primary-clr"
                                        >
                                            Add Wav or MP3 file
                                        </label>
                                        <div
                                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-bg border-dashed rounded-md"
                                        >
                                            <div class="space-y-1 text-center">
                                                <div
                                                        class="flex flex-col text-sm text-secondary-clr"
                                                >
                                                    <label
                                                            for="file-upload"
                                                            class="text-2xl relative cursor-pointer bg-secondary-bg text-primary rounded-md font-semibold text-primary-clr hover:text-secondary-clr focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 p-2 focus-within:ring-secondary-clr"
                                                    >
                                                        <span
                                                                v-if="
                                                                !form.sound_file
                                                            "
                                                        >Upload a new Wav
                                                            file</span
                                                        >
                                                        <span
                                                                v-if="
                                                                form.sound_file
                                                            "
                                                        >{{
                                                                form.sound_file
                                                                    .name
                                                            }}</span
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
                                                    Wav up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3 text-right">
                                    <button
                                            type="submit"
                                            class="inline-flex w-full justify-center py-5 px-4 border border-transparent shadow-sm text-xl font-bold rounded-md text-primary-bg bg-brand-clr hover:bg-brand-clr-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-clr"
                                    >
                                        Update sound
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                    <div class="border-t border-[#222]"/>
                </div>
            </div>
        </template>
    </GuestAndUserBackendLayout>
</template>

<script>
import {useForm, Head} from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import GuestAndUserBackendLayout from "@/Components/Layouts/GuestAndUserBackendLayout";
import {useToast} from "vue-toastification";

//? currently using a workaround to populate the multiselct tags
//? source https://github.com/vueform/multiselect/issues/218#issuecomment-1100748228
//TODO need to implement so the same tag can't be chosen twice. Mentioned in issue @update but not working
export default {
    components: {
        GuestAndUserBackendLayout,

        Head,
        Multiselect,
    },
    props: ["sound", "tags", "allTags", "errors"],

    data(props) {
        return {
            tagsSelector: {
                mode: "tags",
                value: [""],
                closeOnSelect: false,
                options: props.allTags ? props.allTags : null,
                searchable: true,
                createOption: true,
            },
        };
    },

    setup(props) {
        // create toast notifications function
        const toast = useToast();
        const test = [{value: "1", label: "funky"}];

        const form = useForm({
            name: props.sound.name,
            description: props.sound.description,
            sound_file: props.sound.sound_file,
            tags: props.tags,
        });

        //col
        function submit() {
            // update the form tags to a label only array needed to store
            form.tags = form.tags.map(function (obj) {
                return obj.label;
            });

            form.put(`/edit/${props.sound.id}`, {
                onSuccess: () =>
                    // form.reset(),
                    this.toast.info("Edit was successful"),
            });
        }

        return {form, submit, toast, test};
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
