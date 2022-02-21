<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: ["href", "active"],

    computed: {
        classes() {
            return this.active
                ? "block pl-3 pr-4 py-2 border-l-4 border-brand-clr text-base font-medium text-brand-clr bg-secondary-bg focus:bg-secondary-bg focus:outline-none focus:text-brand-clr  focus:border-brand-clr transition duration-150 ease-in-out"
                : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-secondary-clr hover:text-brand-clr hover:bg-secondary-bg hover:border-brand-clr focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out";
        },
    },
};
</script>
