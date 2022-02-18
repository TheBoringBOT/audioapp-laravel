 <template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <template #content>
            <div class="py-12">
                <AudioTable v-bind:audio="audio" />
            </div>
        </template>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Components/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
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
