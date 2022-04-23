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
import WPInput from '../components/WPInput.vue'
import WPFormGroup from '../components/WPFormGroup.vue'

const magicPopupsAjax = (window as any).magic_shortcodes_ajax as { url: string; nonce: string }

const router = useRouter()

</script>
<template>
  <div class="tw-flex tw-gap-4">
    <div class="tw-flex-1">
      <WPMetaBox>
        <template #title>
          <div>
            <WPButton variant="secondary" @click="() => router.push('/')">
              <svg
                xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
              </svg>
              Back
            </WPButton>
          </div>
          <div>
            <h2 class="!tw-p-0">
              Create Shortcode
            </h2>
          </div>
          <div class="tw-ml-auto">
            <WPButton>
              Save Changes
            </WPButton>
          </div>
        </template>
        <template #content>
          <div class="tw-relative tw-block tw-w-full tw-min-h-[400px] tw-p-6">
            <WPFormGroup title="Shortcode name">
              <WPInput
                type="text"
                placeholder="Short name..."
                value="Button"
              />
            </WPFormGroup>
          </div>
        </template>
      </WPMetaBox>
    </div>
    <div class="tw-w-full md:tw-w-[350px]">
      <WPMetaBox>
        <template #title>
          <div>
            <h2 class="!tw-p-0">
              Attributes
            </h2>
          </div>
          <div class="tw-ml-auto">
            <WPButton>
              Add Attribute
            </WPButton>
          </div>
        </template>
        <template #content>
          <div class="tw-relative tw-block tw-w-full">
            <div class="tw-relative tw-block">
              <div class="tw-relative tw-block tw-w-full tw-border-b tw-border-b-wp-border-500">
                <div class="tw-flex">
                  <div class="tw-flex-1 tw-p-4">
                    <WPFormGroup title="Attribute name">
                      <WPInput
                        type="text"
                        placeholder="Attribute name..."
                        value="Title"
                      />
                    </WPFormGroup>
                    <WPFormGroup class="tw-mt-2" title="Default Value">
                      <WPInput
                        type="text"
                        placeholder="Default value..."
                        value="Button"
                      />
                    </WPFormGroup>
                  </div>
                  <div class="tw-w-12 tw-bg-gray-50 tw-border-l tw-border-l-wp-border-500">
                    <div class="tw-flex tw-h-full tw-items-center">
                      <div class="tw-w-full">
                        <a href="#" class="tw-flex tw-h-12 tw-w-full tw-text-center hover:tw-text-rose-600 focus:tw-text-rose-600">
                          <svg class=" tw-m-auto tw-5 tw-h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tw-relative tw-block tw-w-full tw-p-4">
                <WPFormGroup title="Attribute name">
                  <WPInput
                    type="text"
                    placeholder="Attribute name..."
                    value="Title"
                  />
                </WPFormGroup>
                <WPFormGroup class="tw-mt-2" title="Default Value">
                  <WPInput
                    type="text"
                    placeholder="Default value..."
                    value="Button"
                  />
                </WPFormGroup>
                <div class="tw-mt-4 tw-text-right">
                  <WPButton variant="secondary" small>
                    Remove
                  </WPButton>
                  <WPButton class="!tw-ml-4" variant="primary" small>
                    Save Changes
                  </WPButton>
                </div>
              </div>
            </div>
          </div>
        </template>
      </WPMetaBox>
      <WPMetaBoxDonate />
    </div>
  </div>
</template>
