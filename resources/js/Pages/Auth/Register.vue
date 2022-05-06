<template>
    <Head title="Register"/>

    <BreezeValidationErrors class="mb-4 relative"/>
    <div
            v-if="hideRegistration === true"
            class="flex items-center py-2 justify-center bg-blue-500 rounded"
    >
        <span class="mx-auto my-2 text-white text-center"
        >Registration removed for this demo</span
        >
    </div>

    <form v-else @submit.prevent="submit">
        <AvatarInput
                @onAvatarUpload="onAvatarUpload"
                v-model="form.avatar"
                default-src="images/gradient.png"
        />
        <div>
            <BreezeLabel for="name" value="Name"/>
            <BreezeInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
            />
        </div>

        <div class="mt-4">
            <BreezeLabel for="email" value="Email"/>
            <BreezeInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
            />
        </div>
        <div class="mt-4">
            <BreezeLabel
                    for="description"
                    value="Write a short bio for your page"
            />
            <textarea
                    id="description"
                    type="textArea"
                    class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    v-model="form.description"
                    required
            />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password"/>
            <BreezeInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
            />
        </div>
        <div class="mt-4">
            <BreezeLabel for="password_confirmation" value="Confirm Password"/>
            <BreezeInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
            />
        </div>

        <div class="flex-col">
            <div class="flex items-center justify-end mt-4">
                <Link
                        :href="route('login')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Already have an account?
                </Link>

                <BreezeButton
                        @click="() => submit()"
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                >
                    Create Account
                </BreezeButton>
            </div>
        </div>
    </form>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Components/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import AvatarInput from "@/Components/AvatarInput";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import {useToast} from "vue-toastification";
import {Head, Link} from "@inertiajs/inertia-vue3";

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        AvatarInput,
        BreezeValidationErrors,
        Head,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                email: "",
                password: "",
                avatar: "",
                description: "",
                password_confirmation: "",
                terms: false,
            }),
        };
    },

    methods: {
        onAvatarUpload(e) {
            this.form.avatar = e;

        },
        submit() {
            this.form.post(this.route("register"), {
                onFinish: () =>
                    this.form.reset("password", "password_confirmation"),
            });
        },
    },

    setup() {
        // create toast notifications function
        const toast = useToast();
        // to hide registration
        const hideRegistration = false;
        return {toast, hideRegistration};
    },
};
</script>
