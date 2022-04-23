<script lang="ts" setup>
import type { PropType } from 'vue'
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String as PropType<'primary' | 'secondary'>,
    default: 'primary',
  },
  small: {
    type: Boolean,
    default: false,
  },
  as: {
    type: String as PropType<'button' | 'a'>,
    default: 'button',
  },
})

const computedClasses = computed(() => {
  return {
    'button button--custom button-primary': props.variant === 'primary',
    'button button--custom button-secondary': props.variant === 'secondary',
    'button--small': props.small,
  }
})

</script>
<template>
  <button v-if="props.as === 'button'" :class="computedClasses">
    <div class="tw-flex tw-justify-center tw-items-center">
      <slot />
    </div>
  </button>
  <a v-else-if="props.as === 'a'" :class="computedClasses">
    <slot />
  </a>
</template>

<style scoped>
.button.button--custom {
  min-height: 0px !important;
  padding: 6px 10px !important;
  line-height: 1.5!important;
  box-sizing: border-box;
}

.button.button--custom.button--small {
  padding: 4px 8px !important;
  font-size: 12px!important;
}
</style>
