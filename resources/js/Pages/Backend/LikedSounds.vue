<template>
    <Head title="Dashboard"/>

    <GuestAndUserBackendLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">My Favorites</h2>
        </template>
        <template #content>
            <div class="py-12 max-w-7xl w-full">
                <SoundGrid
                        v-if="soundData.length !== 0"
                        :soundData="soundData"
                />
                <div
                        v-else
                        class="text-center text-xl text-white font-semibold"
                >
                    <span>You currently like no sounds.</span>
                </div>
            </div>
        </template>
    </GuestAndUserBackendLayout>
</template>

<script>
import GuestAndUserBackendLayout from "@/Components/Layouts/GuestAndUserBackendLayout.vue";
import {Head} from "@inertiajs/inertia-vue3";
import SoundsTable from "@/Components/Tables/DashboardTable";
import SoundGrid from "@/Components/Grids/SoundGrid";

export default {
    components: {
        GuestAndUserBackendLayout,
        Head,
        SoundsTable,
        SoundGrid,
    },

    props: ["soundData"],
};
</script>
