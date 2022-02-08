<template>
    <div class="py-3 grid gap-5 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <AudioGridItem />
        <AudioGridItem />
        <AudioGridItem />
        <AudioGridItem />
        <AudioGridItem />
        <AudioGridItem />
    </div>
</template>

<script>
import AudioGridItem from "./AudioGridItem";
export default {
    components: {
        AudioGridItem,
    },
};
</script>
