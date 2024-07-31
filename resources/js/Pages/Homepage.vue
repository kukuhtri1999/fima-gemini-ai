<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { marked } from 'marked';
import axios from 'axios';
import Swal from 'sweetalert2';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import MainSection from '@/Components/MainSection.vue';
import PersonalInformation from '@/Components/Part/PersonalInformation.vue';
import FinancialGoals from '@/Components/Part/FinancialGoals.vue';
import FinancialSituations from '@/Components/Part/FinancialSituations.vue';
import FinancialPreferences from '@/Components/Part/FinancialPreferences.vue';

const form = ref({
  _method: 'POST',
  ask: null,
  situation: null,
  financialGoals: null,
  riskScale: null,
  income: null,
  expenses: null,
  investment: null,
  priority: null,
  preference: null,
});

const downloadPDF = async () => {
  try {
    const element = document.getElementById('answers');

    // Generate the PDF
    const canvas = await html2canvas(element, {
      scale: 2,
      // This is the margin for the PDF pages
      width: element.scrollWidth,
      height: element.scrollHeight,
    });

    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF('p', 'mm', 'a4');

    // Add margins
    const margin = 10; // Margin in mm (3 cm)
    const pageHeight = pdf.internal.pageSize.height;

    const imgWidth = 210 - 2 * margin; // A4 width in mm minus margins
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    let heightLeft = imgHeight;
    let position = 0;

    // Add the first page
    pdf.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
    heightLeft -= pageHeight;

    // Add subsequent pages
    while (heightLeft >= 0) {
      position = heightLeft - imgHeight;
      pdf.addPage();
      pdf.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
      heightLeft -= pageHeight;
    }

    // Save the PDF
    pdf.save('financial_plan.pdf');
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: `An error occurred while generating the PDF. Please try again. Error: ${error.message}`,
    });
  }
};

const answer = ref('');
const loading = ref(false);
const showAnswer = ref(false);
const result = ref([]);
const tab = ref('');

const submitForm = async () => {
  showAnswer.value = false;
  loading.value = true;
  answer.value = '';
  try {
    const response = await axios.post(route('home.chat'), form.value);
    result.value = response.data.result;
    showAnswer.value = true;
    loading.value = false;
  } catch (error) {
    loading.value = false;
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: `An error occurred. Please try again. Error : ${error}`,
    });
  }
};
const htmlResult1 = computed(() => marked(result.value[0] || ''));
const htmlResult2 = computed(() => marked(result.value[1] || ''));
const htmlResult3 = computed(() => marked(result.value[2] || ''));
const htmlResult4 = computed(() => marked(result.value[3] || ''));
const htmlResult5 = computed(() => marked(result.value[4] || ''));

const scrollToForm = () => {
  const formElement = document.getElementById('form');
  formElement.scrollIntoView({ behavior: 'smooth' });
};

const currencyNow = ref([]);

const updateCurrency = (newCurrency) => {
  currencyNow.value = newCurrency;
};

const field1 = ref(null);
const field2 = ref(null);
const field3 = ref(null);
const field4 = ref(null);

const test = async () => {
  const dataForm = {
    field1: field1.value ? field1.value.formData : {},
    field2: field2.value ? field2.value.formData : {},
    field3: field3.value ? field3.value.formData : {},
    field4: field4.value ? field4.value.formData : {},
  };
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
    <p class="my-5 mx-2">
      Lets hear what's your problem or what's kind of advise do you need. Fima
      need to know about you and your financial conditions. please fill all our
      questions below so Fima can prepare your Financial Planning for you. Dont
      worry, we dont save any of your data here in our database. I Promise 😉
    </p>
    <VBtn
      @click="fillDummy"
      class="m-2"
      variant="flat"
      color="black"
      size="x-large"
      >Fill Dummy</VBtn
    >
    <div class="tab-form border-[1px] mt-5 solid border-primary rounded-lg">
      <VTabs v-model="tab" bg-color="secondaryLight" color="secondary">
        <VTab value="one">Personal Information</VTab>
        <VTab value="two">Financial Goals</VTab>
        <VTab value="three">Financial Situation</VTab>
        <VTab value="four">Financial Preferences</VTab>
      </VTabs>

      <VWindow v-model="tab">
        <VWindowItem value="one" class="p-5">
          <PersonalInformation ref="field1" />
        </VWindowItem>
        <VWindowItem value="two" class="p-5">
          <FinancialGoals
            ref="field2"
            :currencyNow="currencyNow"
            @updateCurrency="updateCurrency"
          />
        </VWindowItem>
        <VWindowItem value="three" class="p-5">
          <FinancialSituations ref="field3" :currencyNow="currencyNow" />
        </VWindowItem>
        <VWindowItem value="four" class="p-5">
          <FinancialPreferences ref="field4" :currencyNow="currencyNow" />
        </VWindowItem>
      </VWindow>
    </div>
    <div class="my-5">
      <VBtn @click="test" variant="flat" color="primary" size="x-large"
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
        <div class="font-bold mx-2 text-5xl text-purple-600">💵 fima</div>
        <span class="font-bold text-5xl text-black">Financial Plan</span>
      </div>
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 1 : Executive Summary
        </h3>
        <div v-html="htmlResult1" class="markdown-content"></div>
      </div>
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 2 : Financial Snapshot
        </h3>
        <div class="my-5">
          <div v-html="htmlResult2" class="markdown-content"></div>
        </div>
      </div>
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">BAB 3 : Goal Analysis</h3>
        <div class="my-5">
          <div v-html="htmlResult3" class="markdown-content"></div>
        </div>
      </div>
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 4 : Recommended Action Plan
        </h3>
        <div class="my-5">
          <div v-html="htmlResult4" class="markdown-content"></div>
        </div>
      </div>
      <div class="py-10 bab border-y-[1px] solid border-gray-300">
        <h3 class="text-center text-h4 !font-bold">
          BAB 5 : Monitoring, Review adn Conclusion
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
</style>
