<template>
    <div>
        <div class="min-h-screen flex-col flex bg-primary-bg">
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

export default {
    components: {
        Footer,
        LoggedOutNav,
        LoggedInNav,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
};
</script>
