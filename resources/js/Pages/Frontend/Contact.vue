<template>
    <Head title="Home" />
    <LoggedOutLayout>
        <ContentContainer>
            <div class="flex justify-center text-primary-clr">
                <h2 class="text-primary-clr">About</h2>
                <p class="text-secondary-clr">abouyt cool</p>
            </div>
        </ContentContainer>
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
