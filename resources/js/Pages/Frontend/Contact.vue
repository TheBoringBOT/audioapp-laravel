<template>
    <Head title="Home" />
    <LoggedOutLayout>
        <ContentContainer> </ContentContainer>
    </LoggedOutLayout>
</template>

<script>
import LoggedOutLayout from "@/Components/Layouts/LoggedOutLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ContentContainer from "@/Components/Layouts/ContentContainer";

export default {
    components: {
        Head,
        Link,
        LoggedOutLayout,
        ContentContainer,
    },

    methods: {},
};
</script>
