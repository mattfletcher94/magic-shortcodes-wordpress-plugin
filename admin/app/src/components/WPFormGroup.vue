<script lang="ts" setup>
import type { PropType } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  for: {
    type: String,
    default: '',
  },
  state: {
    type: String as PropType<'' | 'error' | 'success'>,
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
})

</script>

<template>
  <div
    class="form-group input-text-wrap relative block w-full" :class="{
      'form-group--required': required
    }"
  >
    <label v-if="props.title" class="relative block w-full" :for="props.for">
      <span class="relative block w-full font-semibold">
        {{ props.title }}
      </span>
      <span
        v-if="props.description" class="relative block w-full text-xs font-normal" :class="{
          'text-gray-500': props.state === '',
          'text-red-500': props.state === 'error',
          'text-green-500': props.state === 'success',
        }"
      >
        {{ props.description }}
      </span>
    </label>
    <div class="relative block w-full mt-1">
      <slot />
    </div>
  </div>
</template>
<style scoped>
.form-group--required label span:nth-child(1)::after {
  content: '*';
  @apply text-red-500 ml-1;
}
</style>
