<template>
    <nav
            class="fixed top-0 left-0 right-0 w-full z-10 bg-nav-bg text-primary-clr border-b border-secondary-bg"
    >
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <h1 v-if="$page.props.auth.user">logged in</h1>
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('sounds')">
                            <BreezeApplicationLogo class="block h-9 w-auto"/>
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-5 sm:-my-px sm:ml-10 md:flex">
                        <BreezeNavLink
                                :href="route('home')"
                                :active="route().current('home')"
                        >
                            Home
                        </BreezeNavLink>
                        <BreezeNavLink
                                :href="route('sounds')"
                                :active="route().current('sounds')"
                        >
                            Sounds
                        </BreezeNavLink>
                        <BreezeNavLink
                                :href="route('about')"
                                :active="route().current('about')"
                        >
                            About
                        </BreezeNavLink>
                    </div>
                </div>

                <div class="hidden md:flex md:items-center md:ml-6">
                    <BreezeNavLink
                            class="px-3"
                            :href="route('login')"
                            :active="route().current('login')"
                    >
                        Login
                    </BreezeNavLink>
                    <BreezeNavLink
                            :href="route('register')"
                            :active="route().current('register')"
                    >
                        <span
                                class="font-semibold text-primary-bg px-6 py-2 bg-brand-clr hover:bg-brand-clr-hover hover:border-0 rounded"
                        >
                            Sign up free</span
                        >
                    </BreezeNavLink>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button
                            @click="
                            showingNavigationDropdown = !showingNavigationDropdown
                        "
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    >
                        <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                        >
                            <path
                                    :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                    :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
                :class="{
                block: showingNavigationDropdown,
                hidden: !showingNavigationDropdown,
            }"
                class="md:hidden pl-3 border-t-2 border-secondary-bg"
        >
            <div class="pt-2 pb-3 space-y-1">
                <BreezeResponsiveNavLink
                        :href="route('home')"
                        :active="route().current('home')"
                >
                    Home
                </BreezeResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <BreezeResponsiveNavLink
                        :href="route('sounds')"
                        :active="route().current('sounds')"
                >
                    Sounds
                </BreezeResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <BreezeResponsiveNavLink
                        :href="route('about')"
                        :active="route().current('about')"
                >
                    About
                </BreezeResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <BreezeResponsiveNavLink
                        :href="route('login')"
                        :active="route().current('login')"
                >
                    Login
                </BreezeResponsiveNavLink>
            </div>

            <div class="pt-2 pb-3 space-y-1">
                <BreezeResponsiveNavLink
                        :href="route('register')"
                        :active="route().current('register')"
                >
                    Sign up free
                </BreezeResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <!--<div class="pt-4 pb-1 border-t border-gray-200">-->
            <!--<div class="px-4">-->
            <!--<div class="font-medium text-base text-gray-800"></div>-->
            <!--<div class="font-medium text-sm text-gray-500"></div>-->
            <!--</div>-->

            <!--<div class="mt-3 space-y-1">-->
            <!--<BreezeResponsiveNavLink-->
            <!--:href="route('logout')"-->
            <!--method="post"-->
            <!--as="button"-->
            <!--&gt;-->
            <!--Log Out-->
            <!--</BreezeResponsiveNavLink>-->
            <!--</div>-->
            <!--</div>-->
        </div>
    </nav>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
};
</script>
