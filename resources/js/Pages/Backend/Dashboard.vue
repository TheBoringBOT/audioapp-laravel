<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>

            <h1>{{ audio }}</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <AudioTable v-bind:audio="audio"/>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Components/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import AudioTable from "@/Components/Tables/DashboardTable";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        AudioTable,
    },

    props: ["audio"],
};
</script>
