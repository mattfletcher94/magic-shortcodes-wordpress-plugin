<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { nextTick, onMounted, ref, watch } from 'vue'
import axios from 'axios'
import { PrismEditor } from 'vue-prism-editor'
// @ts-expect-error No types
import { highlight, languages } from 'prismjs/components/prism-core'
import WPMetaBox from '../components/WPMetaBox.vue'
import WPButton from '../components/WPButton.vue'
import WPCheckbox from '../components/WPCheckbox.vue'
import WPMetaBoxDonate from '../components/WPMetaBoxDonate.vue'
import WPInput from '../components/WPInput.vue'
import WPFormGroup from '../components/WPFormGroup.vue'
import type { ShortcodeDetails } from '../models/ShortcodeDetails'
import 'vue-prism-editor/dist/prismeditor.min.css' // import the styles somewhere
import 'prismjs/components/prism-markup'
import 'prismjs/themes/prism-tomorrow.css'
import WPSelect from '../components/WPSelect.vue'
import WPDropdown from '../components/WPDropdown.vue'
import WPDropdownOption from '../components/WPDropdownOption.vue'

const magicPopupsAjax = (window as any).magic_shortcodes_ajax as { url: string; nonce: string }

const router = useRouter()

const shortCodeDetails = ref<ShortcodeDetails>({
  id: '',
  title: 'button',
  code: '<a class="btn" href="{URL}">\n\t{text}\n</a>\n\n\n\n\n\n\n\n\n\n\n\n',
  attributes: [
    { id: '1', name: 'text', type: 'custom', default: 'Click Me' },
    { id: '2', name: 'URL', type: 'custom', default: '/' },
  ],
})

const prismEditorRef = ref<null | HTMLElement>(null)

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
    type: 'custom',
    default: '',
  })
}

const handleRemoveAttribute = (attributeId: string) => {
  shortCodeDetails.value.attributes = shortCodeDetails.value.attributes.filter(
    attribute => attribute.id !== attributeId,
  )
}

const highlighter = (code: string) => {
  return highlight(code, languages.markup)
}

onMounted(async() => {
  if (prismEditorRef.value) {
    await nextTick()
    const textarea = prismEditorRef.value.querySelector('textarea')
    if (textarea) {
      textarea.addEventListener('blur', () => {
        console.log(textarea.selectionStart)
      })
    }
  }
})

</script>
<template>
  <div class="flex gap-4">
    <div class="flex-1">
      <WPMetaBox>
        <template #title>
          <div>
            <WPButton variant="secondary" @click="() => router.push('/')">
              <svg
                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
              </svg>
              Back
            </WPButton>
          </div>
          <div>
            <h2 class="!p-0">
              Create Shortcode
            </h2>
          </div>
          <div class="ml-auto">
            <WPButton>
              Save Changes
            </WPButton>
          </div>
        </template>
        <template #content>
          <div class="relative block w-full min-h-[400px] p-6">
            <WPFormGroup title="Shortcode Name" description="No spaces or special characters allowed" required>
              <WPInput
                type="text" placeholder="E.g. 'my_button'" :value="shortCodeDetails.title"
                @change="(value) => shortCodeDetails.title = value"
                @blur="(value) => shortCodeDetails.title = replaceSpaces(removeSpecialCharacters(value)).toLowerCase()"
              />
            </WPFormGroup>
            <WPFormGroup
              class="mt-6"
              title="Enable Enclosed Content"
              description="If enabled, you can insert content inbetween the starting and ending tags of your shortcode."
              for="shortCodeEnableEnclosedContent"
            >
              <WPCheckbox id="shortCodeEnableEnclosedContent" label="Enable" />
            </WPFormGroup>
            <WPFormGroup
              class="mt-6"
              title="HTML Content"
              description="Please enter the HTML content you want to display inside the shortcode. Please ensure your HTML is valid."
            >
              <div class="relative mt-2 p-2 border border-wp-border-500 border-b-none bg-gray-50 rounded-t-md">
                <WPDropdown>
                  <template #trigger>
                    <WPButton small>
                      Insert Attribute
                    </WPButton>
                  </template>
                  <template #options>
                    <WPDropdownOption v-for="attr in shortCodeDetails.attributes" :key="attr.id">
                      {{ attr.name }}
                    </WPDropdownOption>
                  </template>
                </WPDropdown>
              </div>
              <div ref="prismEditorRef">
                <prism-editor
                  v-model="shortCodeDetails.code"
                  class="code-editor !h-[330px]"
                  :highlight="(code: string) => highlight(code, languages.markup)"
                  line-numbers
                />
              </div>
            </WPFormGroup>
          </div>
        </template>
      </WPMetaBox>
    </div>
    <div class="w-full md:w-[350px]">
      <WPMetaBox>
        <template #title>
          <div>
            <h2 class="!p-0">
              Attributes
            </h2>
          </div>
          <div class="ml-auto">
            <WPButton @click="handleAddAttribute">
              Add Attribute
            </WPButton>
          </div>
        </template>
        <template #content>
          <div class="relative block w-full">
            <div class="relative block overflow-hidden">
              <TransitionGroup name="attribute-list" tag="div" class="divide-y divide-wp-border-500">
                <div
                  v-for="(attribute) in shortCodeDetails.attributes" :key="attribute.id"
                  class="relative block w-full"
                >
                  <div class="flex">
                    <div class="flex-1 p-4">
                      <WPFormGroup
                        title="Attribute name"
                        required
                      >
                        <WPInput
                          type="text"
                          placeholder="Attribute name..."
                          :value="attribute.name"
                          required
                          @change="(val) => attribute.name = val"
                          @blur="(val) => attribute.name = replaceSpaces(removeSpecialCharacters(val))"
                        />
                      </WPFormGroup>
                      <WPFormGroup
                        class="mt-2"
                        title="Attribute Type"
                        required
                      >
                        <WPSelect
                          :value="attribute.type"
                          :options="[
                            { value: 'custom', label: 'Custom'},
                            { value: 'post_title', label: 'Post / Page Title'},
                          ]"
                          @change="(val) => attribute.type = val as 'custom' | 'post_title'"
                        />
                      </WPFormGroup>
                      <WPFormGroup
                        v-if="attribute.type === 'custom'"
                        class="mt-2"
                        title="Default Value"
                      >
                        <WPInput
                          type="text"
                          placeholder="Default value..."
                          :value="attribute.default"
                          @change="(val) => attribute.default = val"
                        />
                      </WPFormGroup>
                    </div>
                    <div class="w-12 bg-gray-50 border-l border-l-wp-border-500">
                      <div class="flex h-full items-center">
                        <div class="w-full">
                          <button
                            href="#"
                            class="flex h-12 w-full text-center hover:text-rose-600 focus:text-rose-600"
                            @click="() => handleRemoveAttribute(attribute.id)"
                          >
                            <svg
                              class=" m-auto 5 h-5" fill="currentColor" viewBox="0 0 20 20"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                              />
                            </svg>
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
  transition: all 0.3s ease !important;
}

.attribute-list-enter-from,
.attribute-list-leave-to {
  transform: translateY(6px) !important;
  opacity: 0 !important;
}

.attribute-list-leave-active {
  position: absolute !important;
}

.code-editor {
  background: #2d2d2d;
  color: #ccc;
  font-family: Fira code, Fira Mono, Consolas, Menlo, Courier, monospace;
  font-size: 14px;
  line-height: 1.5;
  padding: 5px;
}

.prism-editor__textarea:focus {
  outline: none!important;
  border-color: transparent!important;
  box-shadow: none!important;
}

.prism-editor-wrapper .prism-editor__textarea {
  position: absolute!important;
}

</style>
