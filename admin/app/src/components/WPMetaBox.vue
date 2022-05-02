<script lang="ts" setup>

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
})

</script>
<template>
  <div class="postbox">
    <div class="postbox-header !font-semibold !flex !items-center !justify-start !gap-4 !p-4">
      <h2 v-if="props.title" class="font-semibold !p-0">
        {{ props.title }}
      </h2>
      <slot v-if="!props.title" name="title" />
    </div>
    <div class="inside !p-0 !m-0">
      <slot name="content" />
    </div>
  </div>
</template>

<style>
.postbox.postbox-header h2 .notice {
  display: none!important;
}
</style>
