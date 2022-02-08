<template>
    <div>
        <div class="min-h-screen flex-col flex bg-slate-100">
            <!-- Navbar -->
            <LoggedOutNav/>

            <!-- Page Content -->
            <main
                    class="mx-auto flex-grow px-4 sm:px-6 lg:px-8 py-12 w-full max-w-7xl"
            >
                <slot/>
            </main>
            <!-- Footer -->
            <Footer/>
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
