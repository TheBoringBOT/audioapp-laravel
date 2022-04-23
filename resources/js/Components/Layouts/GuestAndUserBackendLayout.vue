<template>
    <div>
        <!-- Navbar -->
        <LoggedInNav v-if="$page.props.auth.user" />
        <LoggedOutNav v-else />
        <div class="min-h-screen flex-col flex bg-primary-bg">
            <!-- Page Heading -->
            <header class="bg-secondary-bg-hover shadow" v-if="$slots.header">
                <div
                    class="max-w-7xl mx-auto py-6 px-4 sm:px-6 text-primary-clr"
                >
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div
                    class="mx-auto flex-grow px-4 sm:px-6 lg:px-8 w-full max-w-7xl"
                >
                    <slot name="content" />
                </div>
            </main>
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
