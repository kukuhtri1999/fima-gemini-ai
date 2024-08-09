<script setup>
import { reactive } from 'vue';
import VCurrency from '@/Components/VCurrency.vue';
import {
  debtTypesOpt,
  incomeSourceOpt,
  assetTypesOpt,
  expenseCategoriesOpt,
} from '../Scripts/SelectOptions';

const props = defineProps({
  currencyNow: Object,
});

const formData = reactive({
  incomeSources: [],
  monthlyExpenses: [],
  assets: [],
  debts: [],
});

defineExpose({
  formData,
});

const fillDummy = () => {
  // Fill incomeSources with 5 dummy data
  formData.incomeSources = [
    { source: incomeSourceOpt[0], monthlyAmount: 2000 },
    { source: incomeSourceOpt[1], monthlyAmount: 2000 },
    { source: incomeSourceOpt[2], monthlyAmount: 2000 },
    { source: incomeSourceOpt[3], monthlyAmount: 1500 },
    { source: incomeSourceOpt[4], monthlyAmount: 1000 },
  ];

  // Fill monthlyExpenses with 5 dummy data
  formData.monthlyExpenses = [
    { category: expenseCategoriesOpt[0], amount: 1000 },
    { category: expenseCategoriesOpt[1], amount: 800 },
    { category: expenseCategoriesOpt[2], amount: 600 },
    { category: expenseCategoriesOpt[3], amount: 400 },
    { category: expenseCategoriesOpt[4], amount: 200 },
  ];

  // Fill assets with 5 dummy data
  formData.assets = [
    { type: assetTypesOpt[0], value: 100000 },
    { type: assetTypesOpt[1], value: 50000 },
    { type: assetTypesOpt[2], value: 30000 },
    { type: assetTypesOpt[3], value: 20000 },
    { type: assetTypesOpt[4], value: 10000 },
  ];

  // Fill debts with 3 dummy data
  formData.debts = [
    {
      type: debtTypesOpt[0],
      amount: 50000,
      dueDate: 60,
      monthlyInstallment: 1000,
    },
    {
      type: debtTypesOpt[1],
      amount: 130000,
      dueDate: 72,
      monthlyInstallment: 2000,
    },
    {
      type: debtTypesOpt[2],
      amount: 20000,
      dueDate: 24,
      monthlyInstallment: 1500,
    },
  ];
};

// defineExpose({
//   formData,
//   fillDummy,
// });

const rules = {
  required: (value) => !!value || 'Required.',
};
</script>

<template>
  <div class="financial-situations">
    <VRow>
      <VCol cols="12">
        <h2 class="text-h5 mb-4">Understanding Your Financial Situation</h2>
        <p class="mb-4">
          Welcome to the Financial Situations section. This part helps you get a
          clear picture of your overall financial health. We'll guide you
          through listing your income sources, expenses, assets, and debts. This
          information is crucial for making informed financial decisions and
          planning for your future.
        </p>
        <p class="mb-4">Here's what you'll need to provide:</p>
        <ul class="mb-4">
          <li>
            <strong>Income Sources:</strong> List all your regular income, such
            as salary, investments, or rental income.
          </li>
          <li>
            <strong>Expenses:</strong> Detail your monthly spending across
            various categories like housing, food, and transportation.
          </li>
          <li>
            <strong>Assets:</strong> Include valuable items you own, like
            property, vehicles, or savings accounts.
          </li>
          <li>
            <strong>Debts:</strong> List any money you owe, including loans,
            credit cards, or mortgages.
          </li>
        </ul>
        <p class="mb-4">
          Don't worry if you're not sure about exact figures - your best
          estimates are fine. The goal is to give you a comprehensive overview
          of your finances to help you make better financial decisions.
        </p>
        <p class="mb-6">
          Let's get started by filling out your financial information below:
        </p>
      </VCol>
    </VRow>

    <VRow>
      <VCol cols="12">
        <h4 class="my-3">List All of your Monthly Income Sources:</h4>
        <VRow
          v-for="(incomeSource, index) in formData.incomeSources"
          :key="index"
        >
          <VCol cols="6">
            <VSelect
              v-model="incomeSource.source"
              :rules="[rules.required]"
              label="Income Source"
              variant="outlined"
              :items="incomeSourceOpt"
            ></VSelect>
          </VCol>
          <VCol cols="5">
            <VCurrency
              v-model="incomeSource.monthlyAmount"
              :currency="props.currencyNow.value"
              label="Estimated Monthly Amount"
            ></VCurrency>
          </VCol>
          <VCol cols="1">
            <VBtn
              color="error"
              icon="mdi-trash-can-outline"
              variant="tonal"
              @click="formData.incomeSources.splice(index, 1)"
            ></VBtn>
          </VCol>
        </VRow>
        <VBtn
          color="primary"
          variant="flat"
          @click="
            formData.incomeSources.push({
              source: '',
              monthlyAmount: null,
            })
          "
        >
          Add Income Source
        </VBtn>
      </VCol>
    </VRow>

    <VRow>
      <VCol cols="12">
        <h4 class="my-3">List All of your Monthly Expenses</h4>
        <VRow v-for="(expense, index) in formData.monthlyExpenses" :key="index">
          <VCol cols="6">
            <VSelect
              v-model="expense.category"
              :rules="[rules.required]"
              label="Expense Category"
              variant="outlined"
              :items="expenseCategoriesOpt"
            ></VSelect>
          </VCol>
          <VCol cols="5">
            <VCurrency
              v-model="expense.amount"
              :rules="[rules.required]"
              :currency="props.currencyNow.value"
              label="Monthly Amount"
            ></VCurrency>
          </VCol>
          <VCol cols="1">
            <VBtn
              color="error"
              icon="mdi-trash-can-outline"
              variant="tonal"
              @click="formData.monthlyExpenses.splice(index, 1)"
            ></VBtn>
          </VCol>
        </VRow>
        <VBtn
          color="primary"
          variant="flat"
          @click="
            formData.monthlyExpenses.push({
              category: '',
              amount: null,
            })
          "
        >
          Add Expense
        </VBtn>
      </VCol>
    </VRow>

    <VRow>
      <VCol cols="12">
        <h4 class="my-3">List Your Assets</h4>
        <VRow v-for="(asset, index) in formData.assets" :key="index">
          <VCol cols="6">
            <VSelect
              v-model="asset.type"
              :rules="[rules.required]"
              label="Asset Type"
              variant="outlined"
              :items="assetTypesOpt"
            ></VSelect>
          </VCol>
          <VCol cols="5">
            <VCurrency
              v-model="asset.value"
              :rules="[rules.required]"
              :currency="props.currencyNow.value"
              label="Estimated Value"
            ></VCurrency>
          </VCol>
          <VCol cols="1">
            <VBtn
              color="error"
              icon="mdi-trash-can-outline"
              variant="tonal"
              @click="formData.assets.splice(index, 1)"
            ></VBtn>
          </VCol>
        </VRow>
        <VBtn
          color="primary"
          variant="flat"
          @click="formData.assets.push({ type: '', value: null })"
        >
          Add Asset
        </VBtn>
      </VCol>
    </VRow>

    <VRow>
      <VCol cols="12">
        <h4 class="my-3">List Your Debts/Liabilities</h4>
        <VRow v-for="(debt, index) in formData.debts" :key="index">
          <VCol cols="3">
            <VSelect
              v-model="debt.type"
              :rules="[rules.required]"
              label="Debt Type"
              variant="outlined"
              :items="debtTypesOpt"
            ></VSelect>
          </VCol>
          <VCol cols="3">
            <VCurrency
              v-model="debt.amount"
              :rules="[rules.required]"
              :currency="props.currencyNow.value"
              label="Debt Value"
            ></VCurrency>
          </VCol>
          <VCol cols="3">
            <VCurrency
              v-model="debt.monthlyInstallment"
              :rules="[rules.required]"
              :currency="props.currencyNow.value"
              label="Monthly Installment"
            ></VCurrency>
          </VCol>
          <VCol cols="2">
            <VTextField
              v-model="debt.dueDate"
              :rules="[rules.required, rules.number]"
              label="Due Date (months)"
              type="number"
              variant="outlined"
            ></VTextField>
          </VCol>
          <VCol cols="1">
            <VBtn
              color="error"
              icon="mdi-trash-can-outline"
              variant="tonal"
              @click="formData.debts.splice(index, 1)"
            ></VBtn>
          </VCol>
        </VRow>
        <VBtn
          color="primary"
          variant="flat"
          @click="
            formData.debts.push({
              type: '',
              value: null,
              monthlyInstallment: null,
              dueDate: null,
            })
          "
        >
          Add Debt
        </VBtn>
      </VCol>
    </VRow>

    <div class="flex my-5">
      <VBtn
        @click="$emit('changeTab', 'two')"
        class="m-2"
        variant="flat"
        color="secondary"
        >Previous</VBtn
      >
      <VBtn @click="fillDummy" class="m-2" variant="flat" color="black"
        >Fill Dummy Data</VBtn
      >
      <VBtn
        @click="$emit('changeTab', 'four')"
        class="m-2"
        variant="flat"
        color="secondary"
        >Next</VBtn
      >
    </div>
  </div>
</template>
