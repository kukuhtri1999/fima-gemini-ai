<script setup>
import { reactive, defineExpose } from 'vue';

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

const rules = {
  required: (value) => !!value || 'Required.',
};

const countries = [
  'Afghanistan',
  'Albania',
  'Algeria',
  'Andorra',
  'Angola',
  'Antigua and Barbuda',
  'Argentina',
  'Armenia',
  'Australia',
  'Austria',
  'Azerbaijan',
  'Bahamas',
  'Bahrain',
  'Bangladesh',
  'Barbados',
  'Belarus',
  'Belgium',
  'Belize',
  'Benin',
  'Bhutan',
  'Bolivia',
  'Bosnia and Herzegovina',
  'Botswana',
  'Brazil',
  'Brunei',
  'Bulgaria',
  'Burkina Faso',
  'Burundi',
  'Cabo Verde',
  'Cambodia',
  'Cameroon',
  'Canada',
  'Central African Republic',
  'Chad',
  'Chile',
  'China',
  'Colombia',
  'Comoros',
  'Congo, Republic of the',
  'Congo, Democratic Republic of the',
  'Costa Rica',
  "Cote d'Ivoire",
  'Croatia',
  'Cuba',
  'Cyprus',
  'Czech Republic',
  'Denmark',
  'Djibouti',
  'Dominica',
  'Dominican Republic',
  'Ecuador',
  'Egypt',
  'El Salvador',
  'Equatorial Guinea',
  'Eritrea',
  'Estonia',
  'Eswatini',
  'Ethiopia',
  'Fiji',
  'Finland',
  'France',
  'Gabon',
  'Gambia',
  'Georgia',
  'Germany',
  'Ghana',
  'Greece',
  'Grenada',
  'Guatemala',
  'Guinea',
  'Guinea-Bissau',
  'Guyana',
  'Haiti',
  'Honduras',
  'Hungary',
  'Iceland',
  'India',
  'Indonesia',
  'Iran',
  'Iraq',
  'Ireland',
  'Israel',
  'Italy',
  'Jamaica',
  'Japan',
  'Jordan',
  'Kazakhstan',
  'Kenya',
  'Kiribati',
  'Kosovo',
  'Kuwait',
  'Kyrgyzstan',
  'Laos',
  'Latvia',
  'Lebanon',
  'Lesotho',
  'Liberia',
  'Libya',
  'Liechtenstein',
  'Lithuania',
  'Luxembourg',
  'Madagascar',
  'Malawi',
  'Malaysia',
  'Maldives',
  'Mali',
  'Malta',
  'Marshall Islands',
  'Mauritania',
  'Mauritius',
  'Mexico',
  'Micronesia',
  'Moldova',
  'Monaco',
  'Mongolia',
  'Montenegro',
  'Morocco',
  'Mozambique',
  'Myanmar',
  'Namibia',
  'Nauru',
  'Nepal',
  'Netherlands',
  'New Zealand',
  'Nicaragua',
  'Niger',
  'Nigeria',
  'North Korea',
  'North Macedonia',
  'Norway',
  'Oman',
  'Pakistan',
  'Palau',
  'Palestine',
  'Panama',
  'Papua New Guinea',
  'Paraguay',
  'Peru',
  'Philippines',
  'Poland',
  'Portugal',
  'Qatar',
  'Romania',
  'Russia',
  'Rwanda',
  'Saint Kitts and Nevis',
  'Saint Lucia',
  'Saint Vincent and the Grenadines',
  'Samoa',
  'San Marino',
  'Sao Tome and Principe',
  'Saudi Arabia',
  'Senegal',
  'Serbia',
  'Seychelles',
  'Sierra Leone',
  'Singapore',
  'Slovakia',
  'Slovenia',
  'Solomon Islands',
  'Somalia',
  'South Africa',
  'South Korea',
  'South Sudan',
  'Spain',
  'Sri Lanka',
  'Sudan',
  'Suriname',
  'Sweden',
  'Switzerland',
  'Syria',
  'Taiwan',
  'Tajikistan',
  'Tanzania',
  'Thailand',
  'Timor-Leste',
  'Togo',
  'Tonga',
  'Trinidad and Tobago',
  'Tunisia',
  'Turkey',
  'Turkmenistan',
  'Tuvalu',
  'Uganda',
  'Ukraine',
  'United Arab Emirates',
  'United Kingdom',
  'United States',
  'Uruguay',
  'Uzbekistan',
  'Vanuatu',
  'Vatican City',
  'Venezuela',
  'Vietnam',
  'Yemen',
  'Zambia',
  'Zimbabwe',
];
</script>

<template>
  <div class="personal-informations">
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
          :items="countries"
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
    <VBtn @click="fillDummy" class="m-2" variant="flat" color="black"
      >Fill Dummy Data</VBtn
    >
  </div>
</template>
