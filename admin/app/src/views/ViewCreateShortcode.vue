<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { nextTick, onMounted, ref, watch } from 'vue'
import axios from 'axios'
import WPMetaBox from '../components/WPMetaBox.vue'
import WPButton from '../components/WPButton.vue'
import WPMetaBoxDonate from '../components/WPMetaBoxDonate.vue'
import WPInput from '../components/WPInput.vue'
import WPFormGroup from '../components/WPFormGroup.vue'
import type { ShortcodeDetails } from '../models/ShortcodeDetails'

const magicPopupsAjax = (window as any).magic_shortcodes_ajax as { url: string; nonce: string }

const router = useRouter()

const shortCodeDetails = ref<ShortcodeDetails>({
  id: '',
  title: 'my_button',
  attributes: [
    { id: '1', name: 'text', default: 'Click Me' },
    { id: '2', name: 'color', default: '#ff0000' },
  ],
})

const removeSpecialCharacters = (value: string) => {
  return value.replace(/[^\w\s]/gi, '')
}

const replaceSpaces = (value: string) => {
  return value.replace(/\s+/g, '_')
}

const handleAddAttribute = () => {
  shortCodeDetails.value.attributes.push({
    id: Date.now().toString(),
    name: '',
    default: '',
  })
}

const handleRemoveAttribute = (attributeId: string) => {
  shortCodeDetails.value.attributes = shortCodeDetails.value.attributes.filter(
    attribute => attribute.id !== attributeId,
  )
}

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
            <p class="tw-bg-gray-100 tw-rounded-md tw-p-2 tw-mb-6">
              <span>[</span>
              <span class="tw-ml-1">{{ shortCodeDetails.title }}</span>
              <span
                v-for="attribute in shortCodeDetails.attributes.filter(attribute => attribute.name)"
                :key="attribute.id"
                class="tw-ml-1"
              >
                <span class="tw-px-1 tw-py-0.5 tw-rounded-md tw-bg-primary-100">
                  {{ attribute.name.toLowerCase() }}
                </span>
                ="
                <span class="tw-px-1 tw-py-0.5 tw-rounded-md tw-bg-secondary-100">
                  {{ attribute.default }}
                </span>
                "
              </span>
              <span class="tw-ml-1">/]</span>
            </p>
            <WPFormGroup
              title="Shortcode Name"
              description="No spaces or special characters allowed"
              required
            >
              <WPInput
                type="text"
                placeholder="E.g. 'my_button'"
                :value="shortCodeDetails.title"
                @change="(value) => shortCodeDetails.title = value"
                @blur="(value) => shortCodeDetails.title = replaceSpaces(removeSpecialCharacters(value)).toLowerCase()"
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
            <WPButton @click="handleAddAttribute">
              Add Attribute
            </WPButton>
          </div>
        </template>
        <template #content>
          <div class="tw-relative tw-block tw-w-full">
            <div class="tw-relative tw-block tw-overflow-hidden">
              <TransitionGroup
                name="attribute-list"
                tag="div"
                class="tw-divide-y tw-divide-wp-border-500"
              >
                <div
                  v-for="(attribute) in shortCodeDetails.attributes"
                  :key="attribute.id"
                  class="tw-relative tw-block tw-w-full"
                >
                  <div class="tw-flex">
                    <div class="tw-flex-1 tw-p-4">
                      <WPFormGroup title="Attribute name" required>
                        <WPInput
                          type="text"
                          placeholder="Attribute name..."
                          :value="attribute.name"
                          required
                          @change="(val) => attribute.name = val"
                          @blur="(val) => attribute.name = replaceSpaces(removeSpecialCharacters(val))"
                        />
                      </WPFormGroup>
                      <WPFormGroup class="tw-mt-2" title="Default Value">
                        <WPInput
                          type="text"
                          placeholder="Default value..."
                          :value="attribute.default"
                          @change="(val) => attribute.default = val"
                        />
                      </WPFormGroup>
                    </div>
                    <div class="tw-w-12 tw-bg-gray-50 tw-border-l tw-border-l-wp-border-500">
                      <div class="tw-flex tw-h-full tw-items-center">
                        <div class="tw-w-full">
                          <button
                            href="#"
                            class="tw-flex tw-h-12 tw-w-full tw-text-center hover:tw-text-rose-600 focus:tw-text-rose-600"
                            @click="() => handleRemoveAttribute(attribute.id)"
                          >
                            <svg class=" tw-m-auto tw-5 tw-h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </TransitionGroup>
            </div>
          </div>
        </template>
      </WPMetaBox>
      <WPMetaBoxDonate />
    </div>
  </div>
</template>

<style>
.attribute-list-move,
.attribute-list-enter-active,
.attribute-list-leave-active {
  transition: all 0.3s ease!important;
}
.attribute-list-enter-from,
.attribute-list-leave-to {
  transform: translateY(6px)!important;
  opacity: 0!important;
}
.attribute-list-leave-active {
  position: absolute!important;
}
</style>
