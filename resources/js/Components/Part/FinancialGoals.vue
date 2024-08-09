<script setup>
import { reactive, watch } from 'vue';
import VCurrency from '@/Components/VCurrency.vue';
import {
  businessTypeOpt,
  educationTypesOpt,
  currencyOpt,
} from '../Scripts/SelectOptions';

const props = defineProps({
  currencyNow: Object,
});

const emit = defineEmits(['updateCurrency']);

const formData = reactive({
  currency: null,
  financialGoal: '',
  retirementAge: null,
  retirementLifestyle: null,
  retirementLocation: null,
  retirementActivities: null,
  retirementIncome: null,
  existingRetirementAccounts: null,
  existingRetirementAccountsBalance: null,
  socialSecurityIncome: null,
  targetHomePrice: null,
  downPaymentPercentage: null,
  homeYears: null,
  firstTimeBuyer: null,
  children: [],
  consideringFinancialAid: null,
  debtTypes: null,
  debtBalances: null,
  debtInterestRates: null,
  debtMinPayments: null,
  debtPayoffTimeframe: null,
  emergencyFundMonths: null,
  monthlyExpenses: null,
  emergencyFundAccount: null,
  businessType: null,
  startupCosts: null,
  operatingExpenses: null,
  businessFinancing: null,
  businessLaunchTimeframe: null,
  travelDestinations: null,
  travelFrequency: null,
  travelBudget: null,
  nextTripTimeframe: null,
  buySomethingText: null,
  buySomethingPrice: null,
  riskScale: null,
});

const fillDummy = () => {
  formData.currency = { title: 'United States Dollar ($)', value: 'USD' };
  emit('updateCurrency', formData.currency);
  formData.financialGoal = 'Debt Reduction';
  formData.debtTypes = ['Mortgage', 'Business Loans', 'Home Equity Loans'];
  formData.debtBalances = 200000;
  formData.debtMinPayments = 5000;
  formData.debtInterestRates = 10.5;
  formData.debtPayoffTimeframe = 24;
  formData.riskScale = '5';
};

const rules = {
  required: (value) => !!value || 'Required.',
  //   min: (v) => v >= 0 || 'Cannot be null or negative',
};

defineExpose({
  formData,
});

watch(
  () => formData.currency,
  (newCurrency) => {
    emit('updateCurrency', newCurrency);
  },
);

const addChild = () => {
  formData.children.push({
    age: null,
    educationType: '',
    estimatedAnnualCost: null,
  });
};

const removeChild = (index) => {
  formData.children.splice(index, 1);
};
</script>

<template>
  <div class="financial-goals">
    <div class="introduction mb-10 ml-3">
      <h2 class="text-h5 mb-2">Financial Goals</h2>
      <p class="text-body-1">
        Setting financial goals is an important step towards achieving financial
        security and freedom. This form will help you outline your specific
        financial objectives, whether it's planning for retirement, saving for a
        home, or reducing debt. Here's a quick overview of what you'll be
        filling out:
      </p>
      <ul class="text-body-2 ml-4 list-disc">
        <li>Choose your preferred currency</li>
        <li>Select your primary financial goal</li>
        <li>Provide details specific to your chosen goal</li>
        <li>Share information about your current savings and risk tolerance</li>
      </ul>
      <p class="text-body-1 mt-2">
        Remember, there are no right or wrong answers. The more accurate and
        honest you are, the better we can assist you in creating a tailored
        financial plan. Let's get started!
      </p>
    </div>

    <VCombobox
      variant="outlined"
      v-model="formData.currency"
      class="m-2 my-2"
      label="Select Your Currency"
      :items="currencyOpt"
    ></VCombobox>
    <VSelect
      variant="outlined"
      v-model="formData.financialGoal"
      class="m-2 my-2"
      label="What is your Financial Goal ?"
      :items="[
        'Retirement Planning',
        'Buying a Home',
        'Childrens Education',
        'Debt Reduction',
        'Emergency Fund',
        'Starting a Business',
        'Travel',
        'Buy Something',
      ]"
    ></VSelect>

    <!--  RETIREMENT PLANNING -->
    <div
      class="retirement-planning"
      v-if="formData.financialGoal === 'Retirement Planning'"
    >
      <VTextField
        v-model="formData.retirementAge"
        :rules="[rules.required, rules.min]"
        type="number"
        label="At what age do you plan to retire?"
        suffix="years old"
        class="m-2 my-2"
        variant="outlined"
      ></VTextField>
      <VSelect
        v-model="formData.retirementLifestyle"
        label="What kind of lifestyle do you envision in retirement?"
        class="m-2 my-2"
        variant="outlined"
        multiple
        :items="[
          'Traveling extensively',
          'Pursuing hobbies',
          'Spending time with family',
          'Volunteering',
          'Starting a new business',
          'Continuing part-time work',
          'Living in a retirement community',
          'Downsizing to a smaller home',
          'Relocating to a different area',
          'Focusing on health and wellness',
          'Learning new skills',
          'Engaging in cultural activities',
          'Gardening and outdoor activities',
          'Mentoring younger generations',
          'Writing a book or memoir',
          'Participating in sports',
          'Exploring spirituality',
          'Collecting art or antiques',
          'Enjoying fine dining',
          'Adopting a minimalist lifestyle',
        ]"
      />
      <VTextField
        v-model="formData.retirementLocation"
        label="Where do you plan to live?"
        class="m-2 my-2"
        variant="outlined"
      ></VTextField>
      <VTextField
        v-model="formData.retirementActivities"
        label="What activities or hobbies do you want to pursue?"
        class="m-2 my-2"
        variant="outlined"
      ></VTextField>
      <VCurrency
        v-model="formData.retirementIncome"
        :currency="props.currencyNow.value"
        label="What level of income per month do you estimate you'll need to maintain your desired lifestyle?"
        :rules="[rules.min]"
        class="m-2 my-2"
      ></VCurrency>
      <p class="m-2">
        Do you have any existing retirement accounts (e.g., 401k, IRA)?
      </p>
      <VRadioGroup
        v-model="formData.existingRetirementAccounts"
        inline
        class="m-2 my-2"
      >
        <VRadio label="Yes" :value="true"></VRadio>
        <VRadio label="No" :value="false"></VRadio>
      </VRadioGroup>
      <VCurrency
        v-if="formData.existingRetirementAccounts"
        v-model="formData.existingRetirementAccountsBalance"
        :currency="props.currencyNow.value"
        label="If yes, what are their current balances?"
        :rules="[rules.min]"
        class="m-2 my-2"
      ></VCurrency>
      <VCurrency
        v-model="formData.socialSecurityIncome"
        :currency="props.currencyNow.value"
        label="What is your estimated Social Security or pension income per Month ?"
        :rules="[rules.min]"
        class="m-2 my-2"
      ></VCurrency>
    </div>

    <!-- BUYING A HOME -->
    <div class="buying-home" v-if="formData.financialGoal === 'Buying a Home'">
      <VCurrency
        v-model="formData.targetHomePrice"
        :currency="props.currencyNow.value"
        label="What is your target home price range?"
        :rules="[rules.min]"
        class="m-2 my-2"
      ></VCurrency>
      <VTextField
        v-model="formData.downPaymentPercentage"
        type="number"
        label="What percentage down payment are you aiming for?"
        :rules="[rules.min]"
        suffix="%"
        :min="0"
        :max="100"
        class="m-2 my-2"
        variant="outlined"
      ></VTextField>
      <VTextField
        v-model="formData.homeYears"
        type="number"
        label="When would you like to purchase a home (in years)?"
        :rules="[rules.min]"
        suffix="years"
        :min="0"
        :max="100"
        class="m-2 my-2"
        variant="outlined"
      ></VTextField>
      <p class="m-2">Are you a first-time homebuyer?</p>
      <VRadioGroup v-model="formData.firstTimeBuyer" inline class="m-2 my-2">
        <VRadio label="Yes" :value="true"></VRadio>
        <VRadio label="No" :value="false"></VRadio>
      </VRadioGroup>
    </div>

    <!-- Children's Education -->
    <div
      class="childrens-education"
      v-if="formData.financialGoal === 'Childrens Education'"
    >
      <p class="m-2">Please enter your childrens data here:</p>
      <div
        v-for="(child, index) in formData.children"
        :key="index"
        class="my-2"
      >
        <div class="flex">
          <VTextField
            v-model="child.age"
            type="number"
            :label="`Child ${index + 1} Age`"
            :rules="[rules.min]"
            :min="0"
            :max="100"
            suffix="years old"
            class="m-2 w-2/12"
            variant="outlined"
          ></VTextField>
          <VSelect
            v-model="child.educationType"
            :items="educationTypesOpt"
            label="What type of education are you planning for them?"
            multiple
            variant="outlined"
            class="m-2 w-5/12"
          ></VSelect>
          <VCurrency
            v-model="child.estimatedAnnualCost"
            :currency="props.currencyNow.value"
            :label="`For Child ${index + 1}, what is the estimated annual cost?`"
            :rules="[rules.min]"
            class="m-2 w-5/12"
          ></VCurrency>
          <VBtn
            color="error"
            variant="tonal"
            @click="removeChild(index)"
            class="m-2 p-2"
            ><VIcon size="24">mdi-trash-can-outline</VIcon></VBtn
          >
        </div>
      </div>
      <VBtn color="primary" @click="addChild" class="m-2">Add Child</VBtn>

      <p class="m-2">Are you considering any scholarships or financial aid?</p>
      <VRadioGroup
        v-model="formData.consideringFinancialAid"
        inline
        class="m-2"
      >
        <VRadio label="Yes" value="Yes"></VRadio>
        <VRadio label="No" value="No"></VRadio>
      </VRadioGroup>
    </div>

    <!-- Debt Reduction -->
    <div
      class="debt-reduction"
      v-if="formData.financialGoal === 'Debt Reduction'"
    >
      <VSelect
        v-model="formData.debtTypes"
        :items="[
          'Credit Card Debt',
          'Student Loans',
          'Auto Loans',
          'Personal Loans',
          'Mortgage',
          'Home Equity Loans',
          'Business Loans',
          'Medical Debt',
          'Tax Debt',
          'Other',
        ]"
        label="What types of debt do you have?"
        multiple
        variant="outlined"
        chips
        class="m-2"
      ></VSelect>
      <div class="flex">
        <VCurrency
          v-model="formData.debtBalances"
          :currency="props.currencyNow.value"
          label="what is the debt outstanding balance?"
          class="m-2"
          variant="outlined"
        ></VCurrency>

        <VCurrency
          v-model="formData.debtInterestRates"
          label="What is the interest rate?"
          suffix="%"
          prefix=" "
          class="m-2"
        ></VCurrency>
      </div>
      <div class="flex">
        <VCurrency
          v-model="formData.debtMinPayments"
          :currency="props.currencyNow.value"
          label="What are your minimum monthly payments?"
          class="m-2"
        ></VCurrency>
        <VTextField
          v-model="formData.debtPayoffTimeframe"
          label="What is your ideal timeframe or due date for paying off your debt? (in months)"
          type="number"
          class="m-2"
          variant="outlined"
          suffix="months"
        ></VTextField>
      </div>
    </div>

    <!-- Emergency Fund -->
    <div
      class="emergency-fund"
      v-if="formData.financialGoal === 'Emergency Fund'"
    >
      <VTextField
        v-model="formData.emergencyFundMonths"
        label="How many months of essential living expenses would you like your emergency fund to cover?"
        type="number"
        class="m-2"
        variant="outlined"
        suffix="months"
      ></VTextField>
      <VCurrency
        v-model="formData.monthlyExpenses"
        :currency="props.currencyNow.value"
        label="What are your estimated monthly expenses?"
        class="m-2"
        variant="outlined"
      ></VCurrency>
      <VSelect
        v-model="formData.emergencyFundAccount"
        :items="[
          'High-Yield Savings Account',
          'Money Market Account',
          'Certificate of Deposit (CD)',
          'Roth IRA',
          'Brokerage Account',
          'Checking Account',
          'Savings Account',
          'Cash',
          'Peer-to-Peer Lending',
          'Cryptocurrency',
          'Precious Metals',
          'Real Estate',
        ]"
        label="Where do you plan to keep your emergency fund?"
        variant="outlined"
        chips
        class="m-2"
      ></VSelect>
    </div>

    <!-- Starting a Business -->
    <div
      class="starting-a-business"
      v-if="formData.financialGoal === 'Starting a Business'"
    >
      <VSelect
        v-model="formData.businessType"
        :items="businessTypeOpt"
        label="What type of business are you planning to start?"
        class="m-2"
        variant="outlined"
      ></VSelect>
      <VCurrency
        v-model="formData.startupCosts"
        :currency="props.currencyNow.value"
        label="What are your estimated startup costs?"
        class="m-2"
        variant="outlined"
      ></VCurrency>
      <VCurrency
        v-model="formData.operatingExpenses"
        :currency="props.currencyNow.value"
        label="What are your estimated monthly operating expenses?"
        class="m-2"
        variant="outlined"
      ></VCurrency>
      <VSelect
        v-model="formData.businessFinancing"
        :items="[
          'Personal Savings',
          'Business Loan',
          'Investors',
          'Crowdfunding',
          'Angel Investors',
          'Venture Capital',
          'Government Grants',
          'Family and Friends',
          'Credit Cards',
          'Home Equity Loan',
          'Retirement Accounts',
        ]"
        label="How do you plan to finance your business?"
        multiple
        variant="outlined"
        chips
        class="m-2"
      ></VSelect>
      <VTextField
        v-model="formData.businessLaunchTimeframe"
        label="When do you plan to launch your business? (in months)"
        type="number"
        class="m-2"
        variant="outlined"
        suffix="months"
      ></VTextField>
    </div>

    <!-- Travel -->
    <div class="travel" v-if="formData.financialGoal === 'Travel'">
      <VTextField
        v-model="formData.travelDestinations"
        label="What are your dream travel destinations?"
        class="m-2"
        variant="outlined"
      ></VTextField>
      <VSelect
        v-model="formData.travelFrequency"
        :items="[
          'Annually',
          'Bi-annually',
          '4 to 5 times a year',
          'Quarterly',
          'Monthly',
          'Every other month',
          'Seasonally',
          'Once every two years',
        ]"
        label="How often do you plan to travel?"
        class="m-2"
        variant="outlined"
      ></VSelect>
      <VCurrency
        v-model="formData.travelBudget"
        :currency="props.currencyNow.value"
        label="What is your estimated budget per trip?"
        class="m-2"
        variant="outlined"
      ></VCurrency>
      <VTextField
        v-model="formData.nextTripTimeframe"
        label="When would you like to take your next trip? (in months)"
        type="number"
        class="m-2"
        variant="outlined"
        suffix="months"
      ></VTextField>
    </div>

    <!-- Other -->
    <div
      class="buy something"
      v-if="formData.financialGoal === 'Buy Something'"
    >
      <VTextarea
        v-model="formData.buySomethingText"
        label="Please describe me what things do you wanna buy?"
        class="m-2"
        variant="outlined"
        hint="you can tell me more than 1 thing"
      ></VTextarea>
      <VCurrency
        v-model="formData.buySomethingPrice"
        :currency="props.currencyNow.value"
        label="How much the total price of all of these things"
        class="m-2"
        variant="outlined"
      ></VCurrency>
    </div>

    <div v-if="formData.financialGoal">
      <div class="m-2 my-5">
        On a scale of 1 to 10, how comfortable are you with taking risks in your
        investments?
        <p class="text-sm text-gray-400">
          Note: 1 is super safe but low return, 5 is medium risk with medium
          return, 10 is high risk but high return
        </p>
      </div>
      <VRadioGroup v-model="formData.riskScale" inline>
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
    </div>
    <div class="flex my-5">
      <VBtn
        @click="$emit('changeTab', 'one')"
        class="m-2"
        variant="flat"
        color="secondary"
        >Previous</VBtn
      >
      <VBtn @click="fillDummy" class="m-2" variant="flat" color="black"
        >Fill Dummy Data</VBtn
      >
      <VBtn
        @click="$emit('changeTab', 'three')"
        class="m-2"
        variant="flat"
        color="secondary"
        >Next</VBtn
      >
    </div>
  </div>
</template>
