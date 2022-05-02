<script lang="ts" setup>
import { MenuItem } from '@headlessui/vue'

const props = defineProps({
  disabled: {
    type: Boolean,
    default: false,
  },
})

</script>

<template>
  <MenuItem v-slot="{ active }" :disabled="disabled">
    <button
      class="group flex items-center w-full px-2.5 py-2 transition-colors duration-200"
      :class="{
        'bg-primary-500 text-white' : active,
        'opacity-60 cursor-not-allowed': disabled,
      }"
    >
      <slot :active="active" />
    </button>
  </MenuItem>
</template>
