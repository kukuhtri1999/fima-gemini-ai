<script setup>
import {
  reactive, defineExpose, watch, defineProps, defineEmits,
} from 'vue';
import VCurrency from '@/Components/VCurrency.vue';

const props = defineProps({
  currencyNow: String,
});

const emit = defineEmits(['updateCurrency']);

const formData = reactive({
  currency: null,
  financialGoal: null,
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
  charitableOrganizations: null,
  annualDonation: null,
  plannedGiving: null,
  otherFinancialGoal: null,
  hasStartedSaving: null,
  savedAmount: null,
  riskScale: null,
});

const rules = {
  required: (value) => !!value || 'Required.',
  min: (v) => v >= 0 || 'Cannot be null or negative',
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

const businessTypeOptions = [
  'Retail',
  'IT Software',
  'Gym',
  'Restaurant',
  'Consulting',
  'Marketing',
  'Advertising',
  'Accounting',
  'Legal Services',
  'Healthcare',
  'Manufacturing',
  'Construction',
  'Transportation',
  'Logistics',
  'Real Estate',
  'Education',
  'Entertainment',
  'Hospitality',
  'Tourism',
  'Agriculture',
  'Automotive',
  'Beauty',
  'Wellness',
  'Cleaning Services',
  'Repair Services',
  'Landscaping',
  'Catering',
  'Event Planning',
  'Photography',
  'Graphic Design',
];

const educationTypes = [
  'Public College',
  'Private College',
  'Trade School',
  'Vocational Training',
  'Online Education',
  'Apprenticeship',
  'High School',
  'Homeschooling',
  'Tutoring',
  'Language Courses',
  'Skill Development Courses',
  'Professional Certifications',
];

const currencyOptions = [
  { title: 'Algerian Dinar (دج)', value: 'DZD' },
  { title: 'Angolan Kwanza (Kz)', value: 'AOA' },
  { title: 'Argentine Peso ($)', value: 'ARS' },
  { title: 'Armenian Dram (֏)', value: 'AMD' },
  { title: 'Australian Dollar ($)', value: 'AUD' },
  { title: 'Azerbaijani Manat (₼)', value: 'AZN' },
  { title: 'Bahamian Dollar ($)', value: 'BSD' },
  { title: 'Bahraini Dinar (.د.ب)', value: 'BHD' },
  { title: 'Bangladeshi Taka (৳)', value: 'BDT' },
  { title: 'Barbadian Dollar ($)', value: 'BBD' },
  { title: 'Belarusian Ruble (Br)', value: 'BYN' },
  { title: 'Belize Dollar ($)', value: 'BZD' },
  { title: 'Bermudian Dollar ($)', value: 'BMD' },
  { title: 'Bhutanese Ngultrum (Nu.)', value: 'BTN' },
  { title: 'Bolivian Boliviano (Bs.)', value: 'BOB' },
  { title: 'Botswana Pula (P)', value: 'BWP' },
  { title: 'Brazilian Real (R$)', value: 'BRL' },
  { title: 'Brunei Dollar ($)', value: 'BND' },
  { title: 'Bulgarian Lev (Лв.)', value: 'BGN' },
  { title: 'Burundian Franc (FBu)', value: 'BIF' },
  { title: 'Cambodian Riel (៛)', value: 'KHR' },
  { title: 'Canadian Dollar ($)', value: 'CAD' },
  { title: 'Cape Verdean Escudo ($)', value: 'CVE' },
  { title: 'Cayman Islands Dollar ($)', value: 'KYD' },
  { title: 'Central African CFA Franc (Fr)', value: 'XAF' },
  { title: 'Chilean Peso ($)', value: 'CLP' },
  { title: 'Chinese Yuan (¥)', value: 'CNY' },
  { title: 'Colombian Peso ($)', value: 'COP' },
  { title: 'Comorian Franc (CF)', value: 'KMF' },
  { title: 'Congolese Franc (FC)', value: 'CDF' },
  { title: 'Costa Rican Colón (₡)', value: 'CRC' },
  { title: 'Croatian Kuna (kn)', value: 'HRK' },
  { title: 'Cuban Peso (₱)', value: 'CUP' },
  { title: 'Czech Koruna (Kč)', value: 'CZK' },
  { title: 'Cypriot Pound (£)', value: 'CYP' },
  { title: 'Danish Krone (kr)', value: 'DKK' },
  { title: 'Djiboutian Franc (Fdj)', value: 'DJF' },
  { title: 'Dominican Peso (RD$)', value: 'DOP' },
  { title: 'East Caribbean Dollar ($)', value: 'XCD' },
  { title: 'Egyptian Pound (£)', value: 'EGP' },
  { title: 'Eritrean Nakfa (ናቕፋ)', value: 'ERN' },
  { title: 'Ethiopian Birr (Br)', value: 'ETB' },
  { title: 'Euro (€)', value: 'EUR' },
  { title: 'Falkland Islands Pound (£)', value: 'FKP' },
  { title: 'Fijian Dollar ($)', value: 'FJD' },
  { title: 'Gambian Dalasi (D)', value: 'GMD' },
  { title: 'Georgian Lari (ლ)', value: 'GEL' },
  { title: 'Ghanaian Cedi (₵)', value: 'GHS' },
  { title: 'Gibraltar Pound (£)', value: 'GIP' },
  { title: 'Guatemalan Quetzal (Q)', value: 'GTQ' },
  { title: 'Guernsey Pound (£)', value: 'GGP' },
  { title: 'Guinean Franc (FG)', value: 'GNF' },
  { title: 'Guyanese Dollar ($)', value: 'GYD' },
  { title: 'Haitian Gourde (G)', value: 'HTG' },
  { title: 'Honduran Lempira (L)', value: 'HNL' },
  { title: 'Hong Kong Dollar ($)', value: 'HKD' },
  { title: 'Hungarian Forint (Ft)', value: 'HUF' },
  { title: 'Icelandic Krona (kr)', value: 'ISK' },
  { title: 'Indian Rupee (₹)', value: 'INR' },
  { title: 'Indonesian Rupiah (Rp)', value: 'IDR' },
  { title: 'Iranian Rial (﷼)', value: 'IRR' },
  { title: 'Iraqi Dinar (ع.د)', value: 'IQD' },
  { title: 'Israeli Shekel (₪)', value: 'ILS' },
  { title: 'Jamaican Dollar ($)', value: 'JMD' },
  { title: 'Japanese Yen (¥)', value: 'JPY' },
  { title: 'Jersey Pound (£)', value: 'JEP' },
  { title: 'Jordanian Dinar (د.ا)', value: 'JOD' },
  { title: 'Kazakhstani Tenge (₸)', value: 'KZT' },
  { title: 'Kenyan Shilling (Ksh)', value: 'KES' },
  { title: 'Kuwaiti Dinar (د.ك)', value: 'KWD' },
  { title: 'Kyrgyzstani Som (сом)', value: 'KGS' },
  { title: 'Lao Kip (₭)', value: 'LAK' },
  { title: 'Lebanese Pound (ل.ل)', value: 'LBP' },
  { title: 'Lesotho Loti (L)', value: 'LSL' },
  { title: 'Liberian Dollar ($)', value: 'LRD' },
  { title: 'Libyan Dinar (ل.د)', value: 'LYD' },
  { title: 'Macanese Pataca (MOP$)', value: 'MOP' },
  { title: 'Macedonian Denar (ден)', value: 'MKD' },
  { title: 'Malagasy Ariary (Ar)', value: 'MGA' },
  { title: 'Malawian Kwacha (MK)', value: 'MWK' },
  { title: 'Malaysian Ringgit (RM)', value: 'MYR' },
  { title: 'Maldivian Rufiyaa (.ރ)', value: 'MVR' },
  { title: 'Manx Pound (£)', value: 'IMP' },
  { title: 'Mauritanian Ouguiya (UM)', value: 'MRU' },
  { title: 'Mauritian Rupee (₨)', value: 'MUR' },
  { title: 'Mexican Peso ($)', value: 'MXN' },
  { title: 'Moldovan Leu (L)', value: 'MDL' },
  { title: 'Mongolian Tögrög (₮)', value: 'MNT' },
  { title: 'Moroccan Dirham (ر.م.)', value: 'MAD' },
  { title: 'Mozambican Metical (MT)', value: 'MZN' },
  { title: 'Myanmar Kyat (Ks)', value: 'MMK' },
  { title: 'Namibian Dollar ($)', value: 'NAD' },
  { title: 'Nepalese Rupee (रू)', value: 'NPR' },
  { title: 'New Taiwan Dollar (NT$)', value: 'TWD' },
  { title: 'New Zealand Dollar ($)', value: 'NZD' },
  { title: 'Nicaraguan Córdoba (C$)', value: 'NIO' },
  { title: 'Nigerian Naira (₦)', value: 'NGN' },
  { title: 'North Korean Won (₩)', value: 'KPW' },
  { title: 'Norwegian Krone (kr)', value: 'NOK' },
  { title: 'Omani Rial (ر.ع.)', value: 'OMR' },
  { title: 'Pakistani Rupee (Rs)', value: 'PKR' },
  { title: 'Panamanian Balboa (B/.)', value: 'PAB' },
  { title: 'Papua New Guinean Kina (K)', value: 'PGK' },
  { title: 'Paraguayan Guaraní (₲)', value: 'PYG' },
  { title: 'Peruvian Sol (S/.)', value: 'PEN' },
  { title: 'Philippine Peso (₱)', value: 'PHP' },
  { title: 'Polish Zloty (zł)', value: 'PLN' },
  { title: 'Pound Sterling (£)', value: 'GBP' },
  { title: 'Qatari Riyal (ر.ق)', value: 'QAR' },
  { title: 'Romanian Leu (L)', value: 'RON' },
  { title: 'Russian Ruble (₽)', value: 'RUB' },
  { title: 'Rwandan Franc (FRw)', value: 'RWF' },
  { title: 'Samoan Tālā (WS$)', value: 'WST' },
  { title: 'São Tomé and Príncipe Dobra (Db)', value: 'STN' },
  { title: 'Saudi Riyal (﷼)', value: 'SAR' },
  { title: 'Seychellois Rupee (SR)', value: 'SCR' },
  { title: 'Sierra Leonean Leone (Le)', value: 'SLL' },
  { title: 'Singapore Dollar ($)', value: 'SGD' },
  { title: 'Solomon Islands Dollar ($)', value: 'SBD' },
  { title: 'Somali Shilling (Sh)', value: 'SOS' },
  { title: 'South African Rand (R)', value: 'ZAR' },
  { title: 'South Korean Won (₩)', value: 'KRW' },
  { title: 'Sri Lankan Rupee (Rs)', value: 'LKR' },
  { title: 'Sudanese Pound (ج.س.)', value: 'SDG' },
  { title: 'Surinamese Dollar ($)', value: 'SRD' },
  { title: 'Swazi Lilangeni (E)', value: 'SZL' },
  { title: 'Swedish Krona (kr)', value: 'SEK' },
  { title: 'Swiss Franc (Fr.)', value: 'CHF' },
  { title: 'Syrian Pound (LS)', value: 'SYP' },
  { title: 'Tajikistani Somoni (ЅМ)', value: 'TJS' },
  { title: 'Tanzanian Shilling (TSh)', value: 'TZS' },
  { title: 'Thai Baht (฿)', value: 'THB' },
  { title: 'Tongan Paʻanga (T$)', value: 'TOP' },
  { title: 'Trinidad and Tobago Dollar ($)', value: 'TTD' },
  { title: 'Tunisian Dinar (ت.د)', value: 'TND' },
  { title: 'Turkish Lira (₺)', value: 'TRY' },
  { title: 'Turkmenistan Manat (m)', value: 'TMT' },
  { title: 'Ugandan Shilling (USh)', value: 'UGX' },
  { title: 'Ukrainian Hryvnia (₴)', value: 'UAH' },
  { title: 'United Arab Emirates Dirham (د.إ)', value: 'AED' },
  { title: 'United States Dollar ($)', value: 'USD' },
  { title: 'Uruguayan Peso ($)', value: 'UYU' },
  { title: 'Uzbekistani Som (сўм)', value: 'UZS' },
  { title: 'Vanuatu Vatu (VT)', value: 'VUV' },
  { title: 'Venezuelan Bolívar Soberano (Bs.S)', value: 'VES' },
  { title: 'Vietnamese Dong (₫)', value: 'VND' },
  { title: 'Yemeni Rial (﷼)', value: 'YER' },
  { title: 'Zambian Kwacha (ZK)', value: 'ZMW' },
  { title: 'Zimbabwean Dollar ($)', value: 'ZWL' },
];
</script>

<template>
  <div class="personal-informations">
    <VCombobox
      variant="outlined"
      v-model="formData.currency"
      class="m-2 my-2"
      label="Select Your Currency"
      :items="currencyOptions"
    ></VCombobox>
    <VSelect
      variant="outlined"
      v-model="formData.financialGoal"
      class="m-2 my-2"
      label="What is your Financial Goal ?"
      :items="[
        'Retirement Planning',
        'Buying a Home',
        'Children\'s Education',
        'Debt Reduction',
        'Emergency Fund',
        'Starting a Business',
        'Travel',
        'Charitable Giving',
        'Other',
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
      <VTextarea
        v-model="formData.retirementLifestyle"
        label="What kind of lifestyle do you envision in retirement?"
        class="m-2 my-2"
        variant="outlined"
      ></VTextarea>
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
        :currency="props.currencyNow"
        label="If yes, what are their current balances?"
        :rules="[rules.min]"
        class="m-2 my-2"
      ></VCurrency>
      <VCurrency
        v-model="formData.socialSecurityIncome"
        :currency="props.currencyNow"
        label="What is your estimated Social Security or pension income per Month ?"
        :rules="[rules.min]"
        class="m-2 my-2"
      ></VCurrency>
    </div>

    <!-- BUYING A HOME -->
    <div class="buying-home" v-if="formData.financialGoal === 'Buying a Home'">
      <VCurrency
        v-model="formData.targetHomePrice"
        :currency="props.currencyNow"
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
      v-if="formData.financialGoal === 'Children\'s Education'"
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
            :items="educationTypes"
            label="What type of education are you planning for them?"
            multiple
            variant="outlined"
            class="m-2 w-5/12"
          ></VSelect>
          <VCurrency
            v-model="child.estimatedAnnualCost"
            :currency="props.currencyNow"
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
        <VRadio label="Yes" :value="true"></VRadio>
        <VRadio label="No" :value="false"></VRadio>
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
          :currency="props.currencyNow"
          label="what is the debt outstanding balance?"
          class="m-2"
          variant="outlined"
        ></VCurrency>

        <VCurrency
          v-model="formData.debtInterestRates"
          label="What is the interest rate?"
          suffix="%"
          class="m-2"
        ></VCurrency>
      </div>
      <div class="flex">
        <VCurrency
          v-model="formData.debtMinPayments"
          :currency="props.currencyNow"
          label="What are your minimum monthly payments?"
          class="m-2"
        ></VCurrency>
        <VTextField
          v-model="formData.debtPayoffTimeframe"
          label="What is your ideal timeframe for paying off your debt? (in months)"
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
        :currency="props.currencyNow"
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
        :items="businessTypeOptions"
        label="What type of business are you planning to start?"
        class="m-2"
        variant="outlined"
      ></VSelect>
      <VCurrency
        v-model="formData.startupCosts"
        :currency="props.currencyNow"
        label="What are your estimated startup costs?"
        class="m-2"
        variant="outlined"
      ></VCurrency>
      <VCurrency
        v-model="formData.operatingExpenses"
        :currency="props.currencyNow"
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
        :items="['Annually', 'Bi-annually', 'Multiple times a year']"
        label="How often do you plan to travel?"
        class="m-2"
        variant="outlined"
      ></VSelect>
      <VCurrency
        v-model="formData.travelBudget"
        :currency="props.currencyNow"
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

    <!-- Charitable Giving -->
    <div
      class="charitable-giving"
      v-if="formData.financialGoal === 'Charitable Giving'"
    >
      <VTextarea
        v-model="formData.charitableOrganizations"
        label="Which causes or organizations are you passionate about supporting?"
        class="m-2"
        variant="outlined"
      ></VTextarea>
      <VCurrency
        v-model="formData.annualDonation"
        :currency="props.currencyNow"
        label="How much would you like to donate annually?"
        class="m-2"
        variant="outlined"
      ></VCurrency>
      <p class="m-2">
        Are you interested in planned giving or creating a legacy through
        charitable donations?
      </p>
      <VRadioGroup v-model="formData.plannedGiving" inline class="m-2">
        <VRadio label="Yes" :value="true"></VRadio>
        <VRadio label="No" :value="false"></VRadio>
      </VRadioGroup>
    </div>

    <!-- Other -->
    <div class="charitable-giving" v-if="formData.financialGoal === 'Other'">
      <VTextarea
        v-model="formData.otherFinancialGoal"
        label="Please describe your financial goal in detail"
        class="m-2"
        variant="outlined"
        hint="Example : My primary financial goal is to purchase a 5-acre plot of land in [Specific Location/Region]. The purpose of this land acquisition is to build a custom home for my family within the next 3-5 years. Ideally, I'd like the land to have access to utilities and be suitable for construction. My budget for the land purchase is approximately [Budget Amount]. I'm interested in understanding the best strategies to maximize my savings and secure the land at the most favorable price."
      ></VTextarea>
    </div>

    <div v-if="formData.financialGoal">
      <p class="m-2 mt-5">
        Have you started saving some money or there are some money left for this
        ?
      </p>
      <VRadioGroup v-model="formData.hasStartedSaving" inline class="m-2">
        <VRadio label="Yes" :value="true"></VRadio>
        <VRadio label="No" :value="false"></VRadio>
      </VRadioGroup>
      <VCurrency
        v-if="formData.hasStartedSaving"
        v-model="formData.savedAmount"
        :currency="props.currencyNow"
        label="How much have you saved so far?"
        class="m-2"
      ></VCurrency>
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
  </div>
</template>
