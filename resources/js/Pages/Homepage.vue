<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { marked } from 'marked';
import MainSection from '@/Components/MainSection.vue';

const form = useForm({
  _method: 'GET',
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

const props = defineProps({
  result1: String,
  result2: String,
  result3: String,
  result4: String,
  result5: String,
  result6: String,
});

const answer = ref('');
const loading = ref(false);
const showAnswer = ref(false);

const submitForm = () => {
  showAnswer.value = false;
  loading.value = true;
  answer.value = '';
  form.post(route('home.chat'), {
    onSuccess: () => {
      showAnswer.value = true;
      loading.value = false;
    },
    onError: (errors) => {
      loading.value = false;
      notification.value = { type: 'error', message: errors.message };
      setTimeout(() => {
        notification.value = null;
      }, 10000); // Hide after 10 seconds
    },
  });
};

const htmlResult1 = computed(() => marked(props.result1 || ''));
const htmlResult2 = computed(() => marked(props.result2 || ''));
const htmlResult3 = computed(() => marked(props.result3 || ''));
const htmlResult4 = computed(() => marked(props.result4 || ''));
const htmlResult5 = computed(() => marked(props.result5 || ''));
const htmlResult6 = computed(() => marked(props.result6 || ''));
</script>
<template>
  <Head title="Homepage" />
  <MainSection></MainSection>
  <div class="max-w-6xl mx-auto py-20">
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
      9 questions below so Fima can prepare your Financial Planning for you 😉
    </p>
    <VTextarea
      variant="outlined"
      v-model="form.ask"
      class="m-2 my-5"
      label="Tell me whats your financial problem or what financial advise that you need ?"
      hint="Example = I want to buy $50,000 house as soon as possible , i want a financial planning and how much fastest year possible to reach this goals"
    ></VTextarea>
    <VTextarea
      variant="outlined"
      v-model="form.situation"
      class="m-2 my-5"
      label="Tell me whats your name, age, where do you live, martial status, how many child you have ( and age of each child ) "
      hint="Example = My name is Joe Yang , my age is 23 years old. Im live in Singapore. Im married with 2 child ( age 12 and 6 years old)"
    ></VTextarea>
    <VTextField
      variant="outlined"
      v-model="form.financialGoals"
      class="m-2 my-5"
      label="Tell me your top 3 financial goals and when you want to achieve these goals "
      hint="Example = i want to buy $50,000 house, also save money for my 2 children school and collague, buying a $30,000 car "
    ></VTextField>
    <div class="m-2 my-5">
      On a scale of 1 to 10, how comfortable are you with taking risks in your
      investments?
      <p class="text-sm text-gray-400">
        Note: 1 is super safe but low return, 5 is medium risk with medium
        return, 10 is high risk but high return
      </p>
    </div>
    <VRadioGroup v-model="form.riskScale" inline>
      <VRadio label="1" value="1"></VRadio>
      <VRadio label="2" value="2"></VRadio>
      <VRadio label="3" value="3"></VRadio>
      <VRadio label="4" value="4"></VRadio>
      <VRadio label="5" value="5"></VRadio>
      <VRadio label="6" value="6"></VRadio>
      <VRadio label="7" value="7"></VRadio>
      <VRadio label="8" value="8"></VRadio>
      <VRadio label="9" value="9"></VRadio>
      <VRadio label="10" value="10"></VRadio>
    </VRadioGroup>
    <VTextField
      variant="outlined"
      v-model="form.income"
      class="m-2 my-5"
      label="What are your primary sources of income and their approximate monthly amounts after taxes? "
      hint="Example = iam is senior programmer with monthly rate around SGD 4000 "
    ></VTextField>

    <VTextField
      variant="outlined"
      v-model="form.expenses"
      class="m-2 my-5"
      label="What are your major monthly expenses, including any outstanding debts? "
      hint="Example = my monthly expenses usually are for my family, rent house, and food for around SGD 2300. i have debt in Singapore Bank for my car , its around 400 SGD per month with 40 months left. "
    ></VTextField>

    <VTextField
      variant="outlined"
      v-model="form.investment"
      class="m-2 my-5"
      label="What are your current savings and investments, including approximate values? "
      hint="Example = i have store my $10,000 into fixed income mutual funds investment that can return around 6% per year. im also have rent house that can get around 500SGD monthly "
    ></VTextField>

    <VTextField
      variant="outlined"
      v-model="form.priority"
      class="m-2 my-5"
      label="What are your top financial priorities right now? "
      hint="Example = my most priority are paying off debt, saving money for my upcoming children collague, building an emergency fund "
    ></VTextField>

    <VTextField
      variant="outlined"
      v-model="form.preference"
      class="m-2 my-5"
      label="Do you have any specific investment preferences or restrictions? "
      hint="Example = im okay with regular stock investment, im avoiding some super high risk investment like cryptocurrency "
    ></VTextField>

    <VBtn
      @click="submitForm"
      class="mx-2"
      variant="flat"
      color="black"
      size="x-large"
      >Create my Financial Planning</VBtn
    >
    <div v-if="loading" class="m-10 flex justify-center">
      <VProgressCircular indeterminate color="primary"></VProgressCircular>
      <span class="px-2"
        >Sit Tight! Fima will create your financial planning in few minutes 😊
      </span>
    </div>
    <div class="my-5" v-if="showAnswer">
      <!-- <p v-for="(line, index) in result.split('\n')" :key="index">{{ line }}</p>
     -->
      <div class="my-5">
        <h3 class="text-center text-h4">Executive Summary</h3>
        <div v-html="htmlResult1" class="markdown-content"></div>
      </div>
      <div class="my-5">
        <h3 class="text-center text-h4">Financial Snapshot</h3>
        <div v-html="htmlResult2" class="markdown-content"></div>
      </div>
      <div class="my-5">
        <h3 class="text-center text-h4">Goal Analysis</h3>
        <div v-html="htmlResult3" class="markdown-content"></div>
      </div>
      <div class="my-5">
        <h3 class="text-center text-h4">Recommended Action Plan</h3>
        <div v-html="htmlResult4" class="markdown-content"></div>
      </div>
      <div class="my-5">
        <h3 class="text-center text-h4">Monitoring and Review</h3>
        <div v-html="htmlResult5" class="markdown-content"></div>
      </div>
      <div class="my-5">
        <h3 class="text-center text-h4">Conclusion</h3>
        <div v-html="htmlResult6" class="markdown-content"></div>
      </div>
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
}
.markdown-content li {
  margin: 15px 0;
}
</style>
