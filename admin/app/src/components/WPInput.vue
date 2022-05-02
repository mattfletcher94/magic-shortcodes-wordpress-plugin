<script lang="ts" setup>

const props = defineProps({
  value: {
    type: String,
    default: '',
  },
})

const emit = defineEmits<{
  (event: 'change', val: string): void
  (event: 'blur', val: string): void
}>()

</script>
<template>
  <input
    :value="props.value"
    class="relative block w-full"
    @input="(e) => emit('change', (e.target as HTMLInputElement).value)"
    @blur="(e) => emit('blur', (e.target as HTMLInputElement).value)"
  >
</template>
