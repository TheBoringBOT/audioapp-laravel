<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo
                                        class="block h-9 w-auto"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
                            ></div>
                        </div>

                        <div class="hidden md:flex md:items-center md:ml-6">
                            <BreezeNavLink
                                class="px-3"
                                :href="route('login')"
                                :active="route().current('login')"
                            >
                                Home
                            </BreezeNavLink>
                            <BreezeNavLink
                                class="px-3"
                                :href="route('register')"
                                :active="route().current('register')"
                            >
                                About
                            </BreezeNavLink>
                            <BreezeNavLink
                                class="px-3"
                                :href="route('register')"
                                :active="route().current('register')"
                            >
                                Contact
                            </BreezeNavLink>
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
                                class="border-0 hover:border-white focus:border-white"
                            >
                                <button
                                    class="font-semibold text-purple-600 px-6 py-2 border-2 border-purple-600 hover:bg-purple-700 hover:text-white rounded"
                                    :href="route('register')"
                                    :active="route().current('register')"
                                >
                                    Register
                                </button>
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
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </BreezeResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink
                            :href="route('upload')"
                            :active="route().current('upload')"
                        >
                            Upload
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div
                                class="font-medium text-base text-gray-800"
                            ></div>
                            <div
                                class="font-medium text-sm text-gray-500"
                            ></div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <div class="py-12">
                <div class="max-w-7xl mx-auto">
                    <!-- Page Content -->
                    <main>
                        <div class="px-4 sm:px-6 lg:px-8">
                            <slot />
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";

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