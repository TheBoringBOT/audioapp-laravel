<template>
    <Head title="Dashboard" />

    <GuestAndUserBackendLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Dashboard</h2>
        </template>
        <template #content>
            <div class="py-12 max-w-7xl w-full">
                <h2
                    class="font-semibold text-lg leading-tight text-left text-secondary-clr"
                >
                    My Sounds
                </h2>
                <SoundGrid :soundData="soundData" />
            </div>
        </template>
    </GuestAndUserBackendLayout>
</template>

<script>
import GuestAndUserBackendLayout from "@/Components/Layouts/GuestAndUserBackendLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
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
