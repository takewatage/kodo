<script setup lang="ts">
const props = withDefaults(
    defineProps<{
        width?: number
    }>(),
    {
        width: 350,
    }
)
</script>

<template>
    <v-col
        class="side-col d-none d-lg-block"
        cols="auto"
    >
        <v-sheet
            rounded="lg"
            :width="props.width"
            class="pa-2 side-column"
        >
            <slot />
        </v-sheet>
    </v-col>
</template>

<style lang="scss" scoped>
@use '/resources/sass/variables.module';
.side-column {
    min-height: calc(100vh - #{variables.$headerHeight + px} - 32px);
}
</style>
