<script setup>
import { useCurrencyInput } from 'vue-currency-input';
import { watch } from 'vue';

const props = defineProps({ modelValue: Number, currency: String });

const { inputRef, formattedValue, setValue } = useCurrencyInput({
  currency: 'USD',
  currencyDisplay: 'hidden',
  hideCurrencySymbolOnFocus: false,
  hideGroupingSeparatorOnFocus: false,
  precision: 2,
  valueRange: { min: 0, max: 9999999999999999999999 },
  autoDecimalDigits: true,
});

watch(
  () => props.modelValue,
  (value) => {
    setValue(value);
  },
);
</script>

<template>
  <VTextField
    class="currency-field"
    v-model="formattedValue"
    variant="outlined"
    ref="inputRef"
    :prefix="props.currency"
  >
  </VTextField>
</template>
<style>
.currency-field .v-field__input {
  padding: 0;
}

span.v-text-field__prefix__text,
span.v-text-field__suffix__text {
  margin: 0 5px;
  color: rgb(0, 166, 90);
  font-weight: 700;
}
</style>
