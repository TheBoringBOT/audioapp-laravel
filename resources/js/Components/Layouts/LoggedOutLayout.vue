<template>
    <div>
        <div class="min-h-screen flex-col flex bg-primary-bg">
            <!-- Navbar -->
            <LoggedOutNav />

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

export default {
    components: {
        Footer,
        LoggedOutNav,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
};
</script>
