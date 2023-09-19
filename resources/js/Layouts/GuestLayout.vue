<script setup lang="ts">
</script>

<template>
  <v-app id="guestLayout">
    <Transition
      name="page"
      mode="out-in"
      appear
    >
      <v-main :key="$page.url">
        <slot />
      </v-main>
    </Transition>
  </v-app>
</template>

<style>
.page-enter-active,
.page-leave-active {
  transition: all 1s ease-out;
}

.page-enter-from,
.page-leave-to {
  opacity: 0;
}
</style>
