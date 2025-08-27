<script setup lang="ts">
import DokLayout from '@/layouts/DokLayout.vue'
import { reactive, useTemplateRef, computed, nextTick, shallowRef } from 'vue'
import { useElementSize } from '@vueuse/core'
import { useLayout, useTheme } from 'vuetify'
import { FieldType, ProductNameType, usePriceCalculator } from '@/composables/dok/usePriceCalculator'
import { VTextField } from 'vuetify/components'
import { useInputRefs } from '@/composables/dok/useInputRefs'
import CalculatorDialog from '@/components/Dok/CalculatorDialog.vue'
import { ButtonOption } from '@/types/dok'
import MultiButtons from '@/components/Dok/MultiButtons.vue'

defineOptions({ layout: DokLayout })
const { getLayoutItem } = useLayout()
const el = useTemplateRef<HTMLElement>('el')
const size = reactive(useElementSize(el, { width: 0, height: 0 }, { box: 'border-box' }))
const theme = useTheme()
const isCalculator = shallowRef(false)
const currentValue = shallowRef<string>('')
const isFocusRock = shallowRef(true)

const { formRefs, getRefName } = useInputRefs()

const {
    productA,
    productB,
    resultProduct,
    activeProduct,
    activeField,
    isKeyboardVisible,
    productFormReset,
    inputNumber,
    backspace,
    clearActive,
    setActive,
    calculate,
    getCurrentValue,
    isFieldActive,
} = usePriceCalculator()

const showCalculator = () => {
    currentValue.value = getCurrentValue()
    isCalculator.value = true
}

const handleBlur = (productName: ProductNameType, field: FieldType): void => {
    if (!isFocusRock.value) {
        return
    }
    if (resultProduct.value || isCalculator.value) {
        return
    }

    // フォーカスが外れそうになったら再度フォーカスを当てる
    if (isFieldActive(productName, field)) {
        nextTick(() => {
            const target = getRefName(productName, field)
            const targetRef = formRefs[target as keyof typeof formRefs]
            targetRef.value?.focus()
        })
    }
}

const handleCalc = () => {
    isFocusRock.value = false
    nextTick(() => {
        const target = getRefName(activeProduct.value, activeField.value)
        const targetRef = formRefs[target as keyof typeof formRefs]
        targetRef.value?.blur()
        const validate = calculate()
        if (validate) {
            setActiveForm(validate.product, validate.field)
        }
        isFocusRock.value = true
        if (resultProduct.value == 'same') {
            alert('どっちもお得カネ')
        }
    })
}

const handleClick = (productName: ProductNameType, field: FieldType) => {
    setActiveForm(productName, field)
    resultProduct.value = undefined
}

// ボタン配列
const buttons: ButtonOption[] = [
    // 1行目
    { label: '7', action: () => inputNumber('7') },
    { label: '8', action: () => inputNumber('8') },
    { label: '9', action: () => inputNumber('9') },
    { label: 'C', color: 'error', action: clearActive },
    // 2行目
    { label: '4', action: () => inputNumber('4') },
    { label: '5', action: () => inputNumber('5') },
    { label: '6', action: () => inputNumber('6') },
    { icon: 'mdi-backspace-outline', color: 'blue-lighten-3', action: backspace },
    // 3行目
    { label: '1', action: () => inputNumber('1') },
    { label: '2', action: () => inputNumber('2') },
    { label: '3', action: () => inputNumber('3') },
    { label: '計算', color: 'success', rowSpan: 2, action: handleCalc },
    // 4行目
    { icon: 'mdi-calculator', action: showCalculator },
    { label: '0', action: () => inputNumber('0') },
    { label: '.', action: () => inputNumber('.') },
]

const handleButtonClick = (button: ButtonOption) => {
    if (button.action) {
        button.action()
    }
}

const mainHeight = computed((): number => {
    const appBarSize = getLayoutItem('app-bar')?.size || 0
    return window.innerHeight - (size.height + appBarSize)
})

// 現在の入力値を表示用に取得
const getDisplayValue = (product: 'A' | 'B', field: 'price' | 'quantity' | 'packCount'): string => {
    const prod = product === 'A' ? productA.value : productB.value
    return prod[field].replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

const setActiveForm = (product: ProductNameType, field: FieldType) => {
    setActive(product, field)
    nextTick(() => {
        const target = getRefName(product, field)
        const targetRef = formRefs[target as keyof typeof formRefs]
        targetRef.value?.focus()
    })
}

const handleCalculatorClose = (result?: string) => {
    // 計算結果を現在アクティブなフィールドに設定
    if (activeProduct.value && activeField.value) {
        setActiveForm(activeProduct.value, activeField.value)
    }
    if (result) {
        clearActive()
        inputNumber(result)
    }
}
</script>

<template>
    <div
        class="display"
        :style="{ height: mainHeight + 'px', background: theme.current.value.colors.dokSecondary }">
        <div class="form-content d-flex h-100 flex-column">
            <div class="d-flex v-col pa-0 ga-4 h-100">
                <v-sheet
                    autocomplete="off"
                    class="d-flex flex-column pa-2 text-center position-relative"
                    elevation="3"
                    height="100%"
                    rounded="lg"
                    width="100%">
                    <div class="dok-form-input mt-3">
                        <v-text-field
                            ref="priceA"
                            :active="isFieldActive('A', 'price')"
                            :focused="isFieldActive('A', 'price')"
                            color="dokPrimary"
                            label="金額"
                            prefix="¥"
                            type="text"
                            inputmode="none"
                            variant="outlined"
                            :density="comfortable"
                            class="mb-1 custom-input"
                            :model-value="getDisplayValue('A', 'price')"
                            @blur="handleBlur('A', 'price', e)"
                            @click="handleClick('A', 'price', e)"
                            @keydown.prevent />
                    </div>
                    <div class="dok-form-input">
                        <v-text-field
                            ref="quantityA"
                            :active="isFieldActive('A', 'quantity')"
                            color="dokPrimary"
                            label="量"
                            hint="(個,g,ml,cn,m,枚)"
                            persistent-hint
                            type="text"
                            inputmode="none"
                            variant="outlined"
                            :density="comfortable"
                            class="mb-1 custom-input"
                            :model-value="getDisplayValue('A', 'quantity')"
                            @blur="handleBlur('A', 'quantity', e)"
                            @click="handleClick('A', 'quantity', e)"
                            @keydown.prevent />
                    </div>
                    <div class="dok-form-input">
                        <v-text-field
                            ref="packCountA"
                            :active="isFieldActive('A', 'packCount')"
                            color="dokPrimary"
                            label="パック数"
                            hint="(個,箱...)"
                            persistent-hint
                            type="text"
                            inputmode="none"
                            variant="outlined"
                            :density="comfortable"
                            class="mb-1 custom-input mt-3"
                            :model-value="getDisplayValue('A', 'packCount')"
                            @blur="handleBlur('A', 'packCount', e)"
                            @click="handleClick('A', 'packCount', e)"
                            @keydown.prevent />
                    </div>

                    <!--                    <div-->
                    <!--                        class="price-result shine-text"-->
                    <!--                        :class="{ visible: comparison?.cheaperProduct === 'A' }">-->
                    <!--                        <p>単価</p>-->
                    <!--                        <p class="text-h6 font-weight-bold">-->
                    <!--                            <span>{{ formatUnitPrice(resultA) }}</span>-->
                    <!--                        </p>-->
                    <!--                        <p>{{ comparison?.percentDiff.toFixed(1) }}% お得！</p>-->
                    <!--                    </div>-->

                    <v-col v-if="!isKeyboardVisible">
                        <v-img
                            class="gama-img"
                            src="/images/gama_red.png"
                            alt="gama" />
                    </v-col>

                    <Transition
                        name="stamp"
                        appear>
                        <v-img
                            v-if="resultProduct === 'A'"
                            class="result-img stamp-img"
                            :class="{ 'keyboard-active': isKeyboardVisible }"
                            src="/images/otoku.png"
                            alt="gama" />
                    </Transition>
                </v-sheet>
                <v-sheet
                    class="d-flex flex-column pa-2 text-center position-relative"
                    elevation="3"
                    height="100%"
                    rounded="lg"
                    width="100%">
                    <div class="dok-form-input mt-3">
                        <v-text-field
                            ref="priceB"
                            :active="isFieldActive('B', 'price')"
                            color="dokPrimary"
                            label="金額"
                            prefix="¥"
                            type="text"
                            inputmode="none"
                            variant="outlined"
                            :density="comfortable"
                            class="mb-1 custom-input"
                            :model-value="getDisplayValue('B', 'price')"
                            @blur="handleBlur('B', 'price', e)"
                            @click="handleClick('B', 'price', e)"
                            @keydown.prevent />
                    </div>
                    <div class="dok-form-input">
                        <v-text-field
                            ref="quantityB"
                            :active="isFieldActive('B', 'quantity')"
                            color="dokPrimary"
                            label="量"
                            hint="(個,g,ml,cn,m,枚)"
                            persistent-hint
                            type="text"
                            inputmode="none"
                            variant="outlined"
                            :density="comfortable"
                            class="mb-1 custom-input"
                            :model-value="getDisplayValue('B', 'quantity')"
                            @blur="handleBlur('B', 'quantity', e)"
                            @click="handleClick('B', 'quantity', e)"
                            @keydown.prevent />
                    </div>
                    <div class="dok-form-input">
                        <v-text-field
                            ref="packCountB"
                            :active="isFieldActive('B', 'packCount')"
                            color="dokPrimary"
                            label="パック数"
                            hint="(個,箱...)"
                            persistent-hint
                            type="text"
                            inputmode="none"
                            variant="outlined"
                            :density="comfortable"
                            class="mb-1 custom-input mt-3"
                            :model-value="getDisplayValue('B', 'packCount')"
                            @blur="handleBlur('B', 'packCount', e)"
                            @click="handleClick('B', 'packCount', e)"
                            @keydown.prevent />
                    </div>

                    <!--                    <div-->
                    <!--                        class="price-result shine-text"-->
                    <!--                        :class="{ visible: comparison?.cheaperProduct === 'A' }">-->
                    <!--                        <p>単価</p>-->
                    <!--                        <p class="text-h6 font-weight-bold">-->
                    <!--                            <span>{{ formatUnitPrice(resultA) }}</span>-->
                    <!--                        </p>-->
                    <!--                        <p>{{ comparison?.percentDiff.toFixed(1) }}% お得！</p>-->
                    <!--                    </div>-->

                    <v-col v-if="!isKeyboardVisible">
                        <v-img
                            class="gama-img"
                            src="/images/gama_blue.png"
                            alt="gama" />
                    </v-col>

                    <Transition
                        name="stamp"
                        appear>
                        <v-img
                            v-if="resultProduct === 'B'"
                            class="result-img stamp-img"
                            :class="{ 'keyboard-active': isKeyboardVisible }"
                            src="/images/otoku.png"
                            alt="gama" />
                    </Transition>
                </v-sheet>
            </div>
            <div class="d-flex ga-3 v-col-auto pa-0">
                <v-btn
                    class="flex-grow-1 bg-white"
                    variant="outlined"
                    elevation="3"
                    :border="0"
                    @click="productFormReset('A')">
                    リセット
                </v-btn>
                <!--                <v-btn-->
                <!--                    class="flex-grow-1 bg-white"-->
                <!--                    variant="outlined"-->
                <!--                    elevation="3"-->
                <!--                    :border="0">-->
                <!--                    履歴-->
                <!--                </v-btn>-->
                <v-btn
                    class="flex-grow-1 bg-white"
                    variant="outlined"
                    elevation="3"
                    :border="0"
                    @click="productFormReset('B')">
                    リセット
                </v-btn>
            </div>
        </div>

        <v-fade-transition>
            <div
                v-if="isKeyboardVisible"
                ref="el"
                class="calc-content">
                <MultiButtons
                    :buttons="buttons"
                    :columns="4"
                    :rows="4"
                    @button-click="handleButtonClick" />
            </div>
        </v-fade-transition>

        <CalculatorDialog
            v-model="isCalculator"
            :init-value="currentValue"
            @close="handleCalculatorClose"
            @complete="handleCalculatorClose" />
    </div>
</template>

<style lang="scss" scoped>
$button-disabled-overlay: 0;
.main-content {
    transition: height 0.2s ease-in;
    position: relative;
}

.form-content {
    padding: 12px;
    gap: 12px;
}

.dok-form-input {
    z-index: 1;
}

.calc-content {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    max-height: 35%;
    padding: 8px;
}

.calculator-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(4, 1fr);
    gap: 8px;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
}

.grid-item {
    display: flex;
    width: 100%;
    height: 100%;
    position: relative;
}

.gama-img {
    &.keyboard-active {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50%;
    }
}

.calculator-button {
    flex: 1;
    width: 100% !important;
    height: 100% !important;
    min-width: 0 !important;
    min-height: 0 !important;
    margin: 0 !important;
    font-size: 1.2rem !important;

    &:hover,
    &:focus {
        box-shadow: none;
    }
    .v-btn__overlay {
        display: none !important;
    }

    &:focus-visible {
        outline: none;
    }

    &:active {
        transform: scale(0.95);
    }

    &.color-white {
        background-color: #ffffff;
        color: #000000;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    &.color-orange-lighten-3 {
        background-color: #ffcc80;
        color: #000000;
    }

    &.color-blue-lighten-3 {
        background-color: #90caf9;
        color: #000000;
    }

    &.color-success {
        background-color: #4caf50;
        color: #ffffff;
    }
}

.price-result {
    opacity: 0;
    overflow: hidden;
    transform: translate(-100%, 0);
    transition: transform cubic-bezier(0.215, 0.61, 0.355, 1) 0.5s;
    color: #aa8f7b;
    span {
        display: block;
        transform: translate(100%, 0);
        transition: transform cubic-bezier(0.215, 0.61, 0.355, 1) 0.5s;
    }

    &.visible,
    &.visible span {
        transform: translate(0, 0);
    }
}

.shine-text,
.shine-text span {
    position: relative;
    //background: linear-gradient(90deg, #8b7355, #daa520, #ffd700, #fffacd, #ffd700, #daa520, #8b7355);
    background: linear-gradient(90deg, #8b558a, rgba(255, 69, 206, 0.52), #ff45ce, #ffd700, #ff45e6);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shine-flow 10s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.stamp-img {
    transform-origin: center center;
}

.stamp-enter-active {
    animation: stamp-press 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

@keyframes stamp-press {
    0% {
        transform: translateY(-50px) scale(0) rotate(-10deg);
        opacity: 0;
        filter: blur(4px);
    }
    30% {
        transform: translateY(5px) scale(1.2) rotate(0deg);
        opacity: 0.8;
        filter: blur(2px);
    }
    60% {
        transform: translateY(-2px) scale(0.9) rotate(0deg);
        opacity: 1;
        filter: blur(0px);
    }
    100% {
        transform: translateY(0) scale(1) rotate(0deg);
        opacity: 1;
        filter: blur(0px);
    }
}

@keyframes stamp-fade {
    to {
        opacity: 0;
        transform: scale(0.8);
    }
}

@keyframes shine-flow {
    0% {
        background-position: -200% 0;
        filter: brightness(1);
    }
    50% {
        background-position: 200% 0;
        filter: brightness(1.4);
    }
    100% {
        background-position: -200% 0;
        filter: brightness(1);
    }
}
</style>
