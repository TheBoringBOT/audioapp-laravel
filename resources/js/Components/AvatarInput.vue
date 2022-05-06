<template>
    <div
            class="py-5 relative flex flex-col overflow-hidden space-y-5 items-center"
    >
        <div class="rounded-full inline-block relative w-24 h-24">
            <input
                    id="avatar"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    ref="file"
                    @change="change"
            />
            <img
                    :src="src"
                    alt="Avatar"
                    class="h-full w-full object-cover rounded-full"
            />
            <div
                    class="absolute rounded-full overflow-hidden top-0 h-full w-full bg-black bg-opacity-25 flex items-center justify-center"
            >
                <button
                        type="button"
                        @click="browse()"
                        class="rounded-full hover:bg-white hover:bg-opacity-25 p-2 focus:outline-none text-white transition duration-200"
                >
                    <icon name="camera" class="h-6 w-6"></icon>
                </button>
                <button
                        type="button"
                        v-if="value"
                        @click="remove()"
                        class="rounded-full hover:bg-white hover:bg-opacity-25 p-2 focus:outline-none text-white transition duration-200"
                >
                    <icon name="x" class="h-6 w-6"></icon>
                </button>
            </div>
        </div>
        <div>
            <label
                    for="avatar"
                    class="block font-medium text-sm text-gray-700 text-center"
            >Choose your profile image<br/>
                <small>Dimensions: 300x300</small></label
            >
        </div>
    </div>
</template>

<script>
import Icon from "./CameraIcon";

export default {
    emits: ["onAvatarUpload"],
    props: {
        value: File,
        defaultSrc: String,
    },

    data() {
        return {
            src: this.defaultSrc,
        };
    },
    methods: {
        browse() {
            this.$refs.file.click();
        },
        remove() {
            this.$emit("input", null);
        },
        change(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            if (file["size"] < 2111775) {
                reader.onloadend = (file) => {
                    console.log("RESULT", reader.result);
                    this.src = reader.result;
                    this.$emit("onAvatarUpload", e.target.files[0]);
                };
                reader.readAsDataURL(file);
            } else {
                alert("File size can not be bigger than 2 MB");
            }
        },
    },
    components: {
        Icon,
    },
};
</script>
