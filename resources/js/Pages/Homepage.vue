<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { marked } from 'marked';
import axios from 'axios';
import Swal from 'sweetalert2';
import jsPDF from 'jspdf';
import MainSection from '@/Components/MainSection.vue';
import PersonalInformation from '@/Components/Part/PersonalInformation.vue';
import FinancialGoals from '@/Components/Part/FinancialGoals.vue';
import FinancialSituations from '@/Components/Part/FinancialSituations.vue';
import FinancialPreferences from '@/Components/Part/FinancialPreferences.vue';

const clientName = ref('');

const downloadPDF = () => {
  const doc = new jsPDF({
    unit: 'pt',
    format: 'a4',
    orientation: 'portrait',
  });

  const element = document.getElementById('answers');

  const fileName = `Financial Plan for ${clientName.value}.pdf`;
  // Adding the HTML content to the PDF
  doc.html(element, {
    callback(doc) {
      doc.save(fileName);
    },
    margin: [56, 56, 56, 56], // 2cm margins on all sides
    x: 0,
    y: 0,
    html2canvas: {
      scale: 0.8, // Adjust for better quality, higher scale = higher quality but slower
    },
    autoPaging: 'text', // Ensure that the content flows naturally onto the next page
    pagebreak: { mode: 'avoid-all', after: '.bab' },
    width: 425, // Max width of content on PDF page (210mm - 30mm left margin - 30mm right margin)
    windowWidth: 600, // Width of the viewport for rendering
  });
};

const answer = ref('');
const loading = ref(false);
const showAnswer = ref(false);
const result = ref([]);
const tab = ref('');

const htmlResult1 = computed(() => marked(result.value[0] || ''));
const htmlResult2 = computed(() => marked(result.value[1] || ''));
const htmlResult3 = computed(() => marked(result.value[2] || ''));
const htmlResult4 = computed(() => marked(result.value[3] || ''));
const htmlResult5 = computed(() => marked(result.value[4] || ''));

const scrollToForm = () => {
  const formElement = document.getElementById('form');
  formElement.scrollIntoView({ behavior: 'smooth' });
};

const changeTab = (index) => {
  tab.value = index;
  const introElement = document.getElementById('intro');
  introElement.scrollIntoView({ behavior: 'smooth' });
};

const currencyNow = ref([]);

const updateCurrency = (newCurrency) => {
  currencyNow.value = newCurrency;
};

const field1 = ref(null);
const field2 = ref(null);
const field3 = ref(null);
const field4 = ref(null);

const submitForm = async () => {
  const dataForm = {
    field1: field1.value ? field1.value.formData : {},
    field2: field2.value ? field2.value.formData : {},
    field3: field3.value ? field3.value.formData : {},
    field4: field4.value ? field4.value.formData : {},
  };

  clientName.value = dataForm.field1.fullName;
  console.log('Submitted data:', dataForm);
  // Handle form submission, e.g., send data to an API
  showAnswer.value = false;
  loading.value = true;
  answer.value = '';
  try {
    const response = await axios.post(route('home.chat'), dataForm);
    result.value = response.data.result;
    showAnswer.value = true;
    loading.value = false;
  } catch (error) {
    loading.value = false;
    console.error(error.message);
    if (error.response && error.response.status === 422) {
      const { errors } = error.response.data;
      let errorMessages = '<ul>';

      for (const key in errors) {
        if (Object.hasOwnProperty.call(errors, key)) {
          errors[key].forEach((message) => {
            errorMessages += `<li>${message}</li>`;
          });
        }
      }

      errorMessages += '</ul>';

      Swal.fire({
        title: 'Validation Error',
        html: errorMessages,
        icon: 'error',
      });
    } else {
      // Handle other types of errors
      Swal.fire('Error', 'An unexpected error occurred', 'error');
    }
  }
};
</script>
<template>
  <Head title="Homepage" />
  <MainSection @scroll-to-form="scrollToForm"></MainSection>
  <div class="max-w-6xl mx-auto py-20 animate2 px-3" id="form">
    <div
      class="my-3 mx-2 text-h4 !leading-[66px] !font-semibold text-poppins text-gray-800"
    >
      Lets do some
      <span
        style="
          background: linear-gradient(to right, #c65bcf, #10439f);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        "
        >Magic</span
      >
      on your
      <span
        style="
          background: linear-gradient(to right, #006769, #9dde8b);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        "
        >Money</span
      >🪄
    </div>
    <p class="my-5 mx-2" id="intro">
      Lets hear what's your problem or what's kind of advise do you need. Fima
      need to know about you and your financial conditions. please fill all our
      questions below so Fima can prepare your Financial Planning for you. Dont
      worry, we dont save any of your data here in our database. I Promise 😉
    </p>

    <div class="tab-form border-[1px] mt-5 solid border-primary rounded-lg">
      <VTabs v-model="tab" bg-color="secondaryLight" color="secondary">
        <VTab value="one">Personal Information</VTab>
        <VTab value="two">Financial Goals</VTab>
        <VTab value="three">Financial Situation</VTab>
        <VTab value="four">Financial Preferences</VTab>
      </VTabs>

      <VWindow v-model="tab">
        <VWindowItem value="one" class="p-5">
          <PersonalInformation ref="field1" @change-tab="changeTab" />
        </VWindowItem>
        <VWindowItem value="two" class="p-5">
          <FinancialGoals
            ref="field2"
            :currencyNow="currencyNow"
            @updateCurrency="updateCurrency"
            @change-tab="changeTab"
          />
        </VWindowItem>
        <VWindowItem value="three" class="p-5">
          <FinancialSituations
            ref="field3"
            :currencyNow="currencyNow"
            @change-tab="changeTab"
          />
        </VWindowItem>
        <VWindowItem value="four" class="p-5">
          <FinancialPreferences
            ref="field4"
            :currencyNow="currencyNow"
            @change-tab="changeTab"
          />
        </VWindowItem>
      </VWindow>
    </div>
    <div class="my-5">
      <VBtn @click="submitForm" variant="flat" color="primary" size="x-large"
        >Create My Financial Plan</VBtn
      >

      <!-- <VBtn
        @click="submitForm"
        class="mx-2"
        variant="flat"
        color="black"
        size="x-large"
        >Here we go</VBtn
      > -->
    </div>

    <div v-if="loading" class="m-10 flex justify-center">
      <VProgressCircular indeterminate color="primary"></VProgressCircular>
      <span class="px-2"
        >Sit Tight! Fima will create your financial planning in around a minute
        😊
      </span>
    </div>
    <div class="my-5" id="answers" v-if="showAnswer">
      <!-- <div class="my-5" id="answers"> -->
      <!-- <p v-for="(line, index) in result.split('\n')" :key="index">{{ line }}</p>
     -->
      <div class="flex justify-center py-5 animate1">
        <div class="font-bold mx-2 text-5xl text-purple-600">fima</div>
        <span class="font-bold text-5xl text-black">Financial Plan</span>
      </div>
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 1 : Executive Summary
        </h3>
        <div v-html="htmlResult1" class="markdown-content"></div>
      </div>
      <!--ADD_PAGE-->
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 2 : Financial Snapshot
        </h3>
        <div class="my-5">
          <div v-html="htmlResult2" class="markdown-content"></div>
        </div>
      </div>
      <!--ADD_PAGE-->
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">BAB 3 : Goal Analysis</h3>
        <div class="my-5">
          <div v-html="htmlResult3" class="markdown-content"></div>
        </div>
      </div>
      <!--ADD_PAGE-->
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 4 : Recommended Action Plan
        </h3>
        <div class="my-5">
          <div v-html="htmlResult4" class="markdown-content"></div>
        </div>
      </div>
      <!--ADD_PAGE-->
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 5 : Monitoring, Review and Conclusion
        </h3>
        <div v-html="htmlResult5" class="markdown-content"></div>
      </div>
    </div>
    <div class="my-5">
      <VBtn
        v-if="showAnswer"
        @click="downloadPDF"
        variant="flat"
        color="primary"
        size="x-large"
      >
        Download This as PDF
      </VBtn>
    </div>
  </div>
  <div class="bg-black w-full p-5 flex justify-center">
    <div class="max-w-screen-lg flex">
      <div class="w-full">
        <span class="text-[12px] w-full"
          >Copyright @ 2024 by Kukuh Tri Winarno N.</span
        >
      </div>
    </div>
  </div>
</template>
<style>
.markdown-content {
  /* Style for tables */
  width: 100%;
  overflow-x: auto;
}

.markdown-content table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

.markdown-content th,
.markdown-content td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: left;
}

.markdown-content th {
  background-color: #f2f2f2;
}

.markdown-content tr:nth-child(even) {
  background-color: #f9f9f9;
}

.markdown-content tr:hover {
  background-color: #f1f1f1;
}

.markdown-content p {
  margin: 15px 0;
}
.markdown-content ul {
  margin: 15px 0;
  list-style-type: disc;
  list-style-position: inside;
  padding-left: 15px;
}

.markdown-content ol {
  margin: 15px 0;
  list-style-type: auto;
  list-style-position: inside;
  padding-left: 5px;
  font-weight: 300;
}
.markdown-content li {
  margin: 15px 0;
}

/* Reduce the font size globally for the PDF */
#answers {
  font-size: 14px;
  line-height: 1.4;
  word-spacing: 0;
  font-family: Arial, Helvetica, sans-serif;
}

/* Specific adjustments for headings and other elements */
#answers h3 {
  font-size: 20px !important; /* Slightly larger font for headings */
  font-weight: bold;
}
</style>
