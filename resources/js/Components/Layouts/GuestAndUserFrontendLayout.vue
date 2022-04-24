<template>
    <div>
        <div class="min-h-screen flex-col flex bg-primary-bg pt-[64px]">
            <!-- Navbar -->
            <LoggedInNav v-if="$page.props.auth.user" />
            <LoggedOutNav v-else />

            <!-- Page Content -->

            <main>
                <slot />
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
