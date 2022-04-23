<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import WPMetaBox from '../components/WPMetaBox.vue'
import WPButton from '../components/WPButton.vue'
import WPMetaBoxDonate from '../components/WPMetaBoxDonate.vue'
import type { PopupDetails } from '../models/PopupDetails'
import WPLoadingBar from '../components/WPLoadingBar.vue'
import WPDropdown from '../components/WPDropdown.vue'
import WPDropdownOption from '../components/WPDropdownOption.vue'

const magicPopupsAjax = (window as any).magic_shortcodes_ajax as { url: string; nonce: string }

const router = useRouter()

</script>
<template>
  <div class="tw-flex tw-gap-4">
    <div class="tw-flex-1">
      <WPMetaBox>
        <template #title>
          <div>
            <div class="tw-w-8 tw-h-8 tw-rounded-full tw-bg-primary-500 tw-text-white">
              <svg class="tw-h-4 tw-w-4 tw-ml-2 tw-mt-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </div>
          </div>
          <div>
            <h2 class="!tw-p-0">
              Magic Shortcodes
            </h2>
          </div>
          <div class="tw-ml-auto">
            <WPButton @click="() => router.push('/create')">
              Create Shortcode
            </WPButton>
          </div>
        </template>
        <template #content>
          <div class="tw-relative tw-block tw-w-full tw-min-h-[400px]">
            content
          </div>
        </template>
      </WPMetaBox>
    </div>
    <div class="tw-w-full md:tw-w-[350px]">
      <WPMetaBoxDonate />
    </div>
  </div>
</template>
