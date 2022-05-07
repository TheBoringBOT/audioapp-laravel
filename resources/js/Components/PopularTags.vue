<template>
    <div class="mt-4 mb-4 pt-3 lg:pt-4 items-center flex-col flex lg:flex-row">
        <span class="pb-4 lg:pb-0 lg:mr-3 text-primary-clr font-semibold"
            >Top Tags:</span
        >
        <div
            class="flex whitespace-wrap overflow-hidden space-x-2 md:space-x-5"
        >
            <Link
                v-for="tag in popularTags"
                :key="tag.id"
                :href="`/search` + '?' + `keyword=${tag}`"
                :class="
                    currentTag &&
                    currentTag.toString().toLowerCase() ===
                        tag.toString().toLowerCase()
                        ? 'bg-secondary-bg-hover text-brand-clr'
                        : 'text-primary-clr'
                "
                class="cursor-pointer font-semibold bg-secondary-bg hover:bg-secondary-bg-hover transition duration-150 ease-in-out px-3 py-2 rounded"
                ><span
                    class="capitalize whitespace-nowrap overflow-hidden text-ellipsis"
                    >{{ tag }}</span
                ></Link
            >
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default { components: { Link }, props: ["popularTags", "currentTag"] };
</script>
