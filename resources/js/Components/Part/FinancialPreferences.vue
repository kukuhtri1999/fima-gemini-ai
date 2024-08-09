<script setup>
import { reactive } from 'vue';
import {
  investmentOpt,
  investmentRestrictionOpt,
  insuranceCoverageOpt,
} from '../Scripts/SelectOptions';

const props = defineProps({
  currencyNow: Object,
});

const formData = reactive({
  investmentPreferences: [],
  investmentRestrictions: [],
  insuranceCoverage: null,
  additionalConcerns: '',
});

defineExpose({
  formData,
});

const rules = {
  required: (value) => !!value || 'Required.',
};

const fillDummy = () => {
  formData.investmentPreferences = [
    investmentOpt[0],
    investmentOpt[1],
    investmentOpt[2],
  ];
  formData.investmentRestrictions = [
    investmentRestrictionOpt[0],
    investmentRestrictionOpt[1],
  ];
  formData.insuranceCoverage = [
    insuranceCoverageOpt[0],
    insuranceCoverageOpt[1],
  ];
  formData.additionalConcerns = "I'm interested in sustainable and ethical investment options. Also, I'd like to explore ways to optimize my tax strategy.";
};
</script>

<template>
  <div class="financial-preferences">
    <div class="introduction mb-6">
      <h2 class="text-h5 mb-3">Understanding Your Financial Preferences</h2>
      <p class="text-body-1">
        Welcome to the Financial Preferences section. This part helps us
        understand your financial goals and concerns better. Here's a quick
        overview of what we'll ask:
      </p>
      <ul class="text-body-2 mt-2">
        <li>
          <strong>Investment Preferences:</strong> These are the types of
          investments you're interested in, like stocks, bonds, or real estate.
        </li>
        <li>
          <strong>Investment Restrictions:</strong> Any limitations you have on
          where your money is invested, often based on personal or ethical
          considerations.
        </li>
        <li>
          <strong>Insurance Coverage:</strong> The types of insurance you're
          looking for to protect your assets and loved ones.
        </li>
        <li>
          <strong>Additional Concerns:</strong> Any other financial matters
          you'd like to discuss or have questions about.
        </li>
      </ul>
      <p class="text-body-2 mt-2">
        Don't worry if you're unsure about some options - we're here to guide
        you through the process and explain anything that's unclear.
      </p>
    </div>

    <div class="my-5">
      <VSelect
        v-model="formData.investmentPreferences"
        :items="investmentOpt"
        label="Investment Preferences"
        multiple
        chips
        persistent-hint
        variant="outlined"
        hint="Select your preferred investment options"
      ></VSelect>
    </div>
    <div class="my-5">
      <VSelect
        v-model="formData.investmentRestrictions"
        :items="investmentRestrictionOpt"
        label="Investment Restrictions"
        multiple
        chips
        persistent-hint
        variant="outlined"
        hint="Please specify any investment restrictions or ethical considerations you have "
      ></VSelect>
    </div>

    <div class="my-5">
      <VSelect
        v-model="formData.insuranceCoverage"
        :items="insuranceCoverageOpt"
        label="Insurance Coverage"
        multiple
        chips
        persistent-hint
        variant="outlined"
        hint="Select your preferred insurance coverage options"
      ></VSelect>
    </div>

    <div class="my-5">
      <VTextarea
        v-model="formData.additionalConcerns"
        label="Additional Notes or Concerns"
        placeholder="Please share any additional financial concerns or questions you have."
        rows="4"
        variant="outlined"
      ></VTextarea>
    </div>

    <div class="flex my-5">
      <VBtn
        @click="$emit('changeTab', 'three')"
        class="m-2"
        variant="flat"
        color="secondary"
        >Previous</VBtn
      >
      <VBtn @click="fillDummy" class="m-2" variant="flat" color="black"
        >Fill Dummy Data</VBtn
      >
    </div>
  </div>
</template>
