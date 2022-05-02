<script setup lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import type { PropType } from 'vue'

const props = defineProps({
  width: {
    type: String,
    default: '210px',
  },
  anchor: {
    type: String as PropType<'left' | 'right'>,
    default: 'left',
  },
})
</script>

<template>
  <Menu as="div" class="block z-100">
    <MenuButton as="div">
      <slot name="trigger" />
    </MenuButton>
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        class="!absolute bg-white bg-opacity-80 backdrop-filter backdrop-blur divide-y divide-wp-border-500 rounded-md shadow-lg overflow-hidden ring-1 ring-black ring-opacity-5 focus:outline-none z-20"
        :class="{
          'right-0 origin-top-right': props.anchor === 'right',
          'left-0 origin-top-left': props.anchor === 'left',
        }"
        :style="{
          width: props.width,
        }"
      >
        <slot name="options" />
      </MenuItems>
    </transition>
  </Menu>
</template>
