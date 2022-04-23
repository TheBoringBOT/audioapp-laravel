<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Dashboard</h2>
        </template>
        <template #content>
            <div class="py-12">
                <SoundGrid :soundData="soundData" />
            </div>
        </template>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Components/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import SoundsTable from "@/Components/Tables/DashboardTable";
import SoundGrid from "@/Components/Grids/SoundGrid";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        SoundsTable,
        SoundGrid,
    },

    props: ["soundData"],
};
</script>
