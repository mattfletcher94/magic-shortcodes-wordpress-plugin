<script lang="ts" setup>

const props = defineProps({
  checked: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
    default: '',
  },
  id: {
    type: String,
    default: '',
  },
})

const emit = defineEmits<{
  (event: 'change', val: boolean): void
}>()

</script>
<template>
  <div class="relative block w-full">
    <input
      :id="props.id"
      type="checkbox"
      :checked="props.checked"
      class="relative inline-block align-top"
      @input="(e) => emit('change', (e.target as HTMLInputElement).checked)"
    >
    <label
      v-if="props.label"
      :for="props.id"
      class="relative inline-block ml-1 align-middle"
    >
      {{ props.label }}
    </label>
  </div>
</template>
