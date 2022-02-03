<template>
    <Head title="Home" />
    <BreezeGuestLayout>
        <h1>Home {{ $inertia.page.props.appName }}</h1>
    </BreezeGuestLayout>
</template>

<script>
import BreezeGuestLayout from "@/Components/Layouts/Guest.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
        Link,
        BreezeGuestLayout,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
};
</script>
