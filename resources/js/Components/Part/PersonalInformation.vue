<script setup>
import { reactive } from 'vue';
import { countriesOpt } from '../Scripts/SelectOptions';

const formData = reactive({
  fullName: '',
  age: null,
  gender: '',
  martialStatus: '',
  numberOfChildren: null,
  country: '',
  city: '',
  employmentStatus: '',
  industry: '',
});

defineExpose({
  formData,
});

const fillDummy = () => {
  formData.fullName = 'Kukuh Tri';
  formData.age = 25;
  formData.gender = 'Male';
  formData.martialStatus = 'Single';
  formData.numberOfChildren = 0;
  formData.country = 'United States';
  formData.city = 'Washington DC';
  formData.employmentStatus = 'Employed';
  formData.industry = 'Technology';
};

const rules = {
  required: (value) => !!value || 'Required.',
};
</script>

<template>
  <div class="personal-informations">
    <div class="introduction mb-10 ml-3">
      <h2 class="text-h5 mb-2">Personal Information</h2>
      <p class="text-body-1">
        We'd like to get to know you better. This form asks for basic
        information about you, such as your name, age, and where you live. Don't
        worry, all information is kept private and secure.
      </p>
      <p class="text-body-1">
        Please fill out each field as accurately as possible. If you're unsure
        about any question, you can leave it blank for now. Remember, there are
        no right or wrong answers - we just want to learn about you!
      </p>
    </div>

    <div class="d-flex">
      <div class="w-50 mr-2">
        <VTextField
          variant="outlined"
          v-model="formData.fullName"
          class="m-2 my-2"
          label="Your Full Name"
        >
        </VTextField>
      </div>
      <div class="w-50 ml-2">
        <VTextField
          variant="outlined"
          v-model="formData.age"
          type="number"
          :min="0"
          class="m-2 my-2"
          label="Your Age"
        ></VTextField>
      </div>
    </div>

    <div class="d-flex">
      <div class="w-50 pr-2">
        <VSelect
          variant="outlined"
          v-model="formData.gender"
          class="m-2 my-2"
          label="Gender"
          :items="['Male', 'Female', 'Other']"
        ></VSelect>
      </div>
      <div class="w-50 pl-2">
        <VSelect
          variant="outlined"
          v-model="formData.martialStatus"
          class="m-2 my-2"
          label="Martial Status"
          :items="['Single', 'Married', 'Divorced', 'Widowed']"
        ></VSelect>
      </div>
    </div>

    <div class="d-flex">
      <div class="mr-2 w-50">
        <VTextField
          variant="outlined"
          v-model="formData.numberOfChildren"
          type="number"
          :min="0"
          class="m-2 my-5"
          label="Number of Children"
        ></VTextField>
      </div>
      <div class="ml-2 w-50">
        <VCombobox
          variant="outlined"
          v-model="formData.country"
          class="m-2 my-5"
          label="Country"
          :items="countriesOpt"
        ></VCombobox>
      </div>
    </div>

    <div class="d-flex">
      <div class="w-50 pr-2">
        <VTextField
          variant="outlined"
          v-model="formData.city"
          class="m-2 my-2"
          label="City"
        ></VTextField>
      </div>
      <div class="w-50 pl-2">
        <VSelect
          variant="outlined"
          v-model="formData.employmentStatus"
          class="m-2 my-2"
          label="Employment Status"
          :items="[
            'Employed Full-Time',
            'Employed Part-Time',
            'Unemployed',
            'Self-employed',
            'Retired',
          ]"
        ></VSelect>
      </div>
    </div>

    <VTextField
      variant="outlined"
      v-model="formData.industry"
      class="m-2 my-5"
      label="Industry"
    ></VTextField>
    <div class="flex my-5">
      <VBtn @click="fillDummy" class="m-2" variant="flat" color="black"
        >Fill Dummy Data</VBtn
      >
      <VBtn
        @click="$emit('changeTab', 'two')"
        class="m-2"
        variant="flat"
        color="secondary"
        >Next</VBtn
      >
    </div>
  </div>
</template>
