<script setup lang="ts">
import { ref } from 'vue'
import { MdEditor } from 'md-editor-v3'
import 'md-editor-v3/lib/style.css'
import { uuid } from 'vue3-uuid'
const text = ref('Hello Editor!')

const props = defineProps<{
    modelValue: string
    label: string
}>()
const emit = defineEmits<{
    'update:modelValue': [val: string]
}>()

const fieldActive = ref(false)
const htmlId = uuid.v4()

const onFocus = (func: Function) => {
    fieldActive.value = true
    func()
}
const onBlur = (func: Function) => {
    fieldActive.value = false
    func()
}
</script>

<template>
    <VField
        :id="htmlId"
        density="compact"
        variant="outlined"
        :active="fieldActive"
        class="editor-field label-bold"
        label="label"
    >
        <template #default="{ isActive, isFocused, focus, blur }">
            <MdEditor
                :editor-id="htmlId"
                :model-value="modelValue"
                theme="dark"
                class="app-editor-one"
                :preview="false"
                :toolbars="[]"
                :footers="[]"
                @onChange="(v: string) => $emit('update:modelValue', v)"
                @focus="onFocus(focus)"
                @blur="onBlur(blur)"
            />
        </template>
    </VField>
</template>

<style lang="scss">
.editor-field {
    .app-editor-one {
        --md-bk-color: transparent;
        --md-color: #ffffff;
        --md-border-color: #ffffff;
        border-radius: 5px;
        border: 0;

        .cm-editor {
            color: #ffffff;
        }
    }
}
.v-field--center-affix.editor-field {
    .v-label.v-field-label {
        top: 5%;
        transform: translateY(-50%);
    }
}
</style>
