<template>
    <div>
        <div class="min-h-screen flex-col flex bg-primary-bg pt-[64px]">
            <!-- Navbar -->
            <LoggedInNav v-if="$page.props.auth.user" />
            <LoggedOutNav v-else />
            <!-- Page Heading -->
            <header class="bg-secondary-bg-hover shadow" v-if="$slots.header">
                <div
                    class="max-w-7xl mx-auto py-6 px-4 lg:px-8 text-primary-clr"
                >
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div v-if="$page.props.flash.message" class="alert">
                    {{ $page.props.flash.message }}
                </div>
                <div
                    class="mx-auto flex-grow px-4 sm:px-6 lg:px-8 w-full max-w-7xl"
                >
                    <slot name="content" />
                </div>
            </main>
            <!-- Footer -->
            <Footer />
        </div>
    </div>
</template>

<script>
import Footer from "@/Components/Footers/Footer";
import LoggedOutNav from "@/Components/Navbars/LoggedOutNav";
import LoggedInNav from "@/Components/Navbars/LoggedInNav";
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";

export default {
    components: {
        Footer,
        LoggedOutNav,
        LoggedInNav,
    },

    created() {
        this.message && this.toast.info(this.message);
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
    setup() {
        const message = computed(() => usePage().props.value.flash.message);
        // create toast notifications function
        const toast = useToast();
        return { toast, message };
    },
};
</script>
