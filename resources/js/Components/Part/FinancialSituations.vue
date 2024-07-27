<script setup>
import { reactive, defineExpose } from 'vue';
import VCurrency from '@/Components/VCurrency.vue';

const props = defineProps({
  currencyNow: String,
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

const debtTypes = [
  'Credit Card Debt',
  'Mortgage',
  'Auto Loan',
  'Student Loan',
  'Personal Loan',
  'Medical Debt',
  'Home Equity Loan',
  'Business Loan',
  'Payday Loan',
  'Tax Debt',
  'Credit Line',
  'Retail Store Credit',
  'Family Loan',
  'Peer-to-Peer Loan',
  'Consolidation Loan',
  'Installment Loan',
  'Secured Loan',
  'Unsecured Loan',
  'Overdraft',
  'Lease Agreement',
  'Timeshare Loan',
  'Boat Loan',
  'RV Loan',
  'Motorcycle Loan',
  'Construction Loan',
  'Bridge Loan',
  'Balloon Payment Loan',
  'Refinanced Loan',
  'Judgment Lien',
  'Cosigned Loan',
  'Other',
];

const assetTypes = [
  'Real Estate',
  'Stocks',
  'Bonds',
  'Mutual Funds',
  'ETFs',
  'Savings Accounts',
  'Certificates of Deposit',
  'Retirement Accounts (401k, IRA)',
  'Vehicles',
  'Jewelry',
  'Art',
  'Collectibles',
  'Business Ownership',
  'Intellectual Property',
  'Precious Metals',
  'Cryptocurrencies',
  'Life Insurance Policies',
  'Annuities',
  'Treasury Securities',
  'Commodities',
  'Peer-to-Peer Lending',
  'Foreign Currency',
  'Rental Properties',
  'Equipment',
  'Livestock',
  'Other',
];

const expenseCategories = [
  'Housing',
  'Utilities',
  'Food',
  'Transportation',
  'Healthcare',
  'Insurance',
  'Debt Payments',
  'Entertainment',
  'Education',
  'Childcare',
  'Groceries',
  'Dining Out',
  'Clothing',
  'Personal Care',
  'Household Supplies',
  'Subscriptions',
  'Gifts',
  'Donations',
  'Vacation/Travel',
  'Hobbies',
  'Pets',
  'Home Maintenance',
  'Auto Expenses',
  'Gym Membership',
  'Cell Phone',
  'Internet',
  'Cable/Streaming',
  'Credit Card Payments',
  'Student Loans',
  'Other',
];

const incomeSourceOptions = [
  'Salary',
  'Investments',
  'Rental Income',
  'Business Income',
  'Pension',
  'Social Security',
  'Disability Benefits',
  'Unemployment Benefits',
  'Child Support',
  'Alimony',
  'Inheritance',
  'Lottery Winnings',
  'Royalties',
  'Freelance Work',
  'Consulting Fees',
  'Interest Income',
  'Dividend Income',
  'Capital Gains',
  'Annuity Payments',
  'Other Income',
];

const rules = {
  required: (value) => !!value || 'Required.',
};
</script>

<template>
  <div class="personal-informations">
    <VRow>
      <VCol cols="12">
        <h4 class="my-3">List All of your Income Sources:</h4>
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
              :items="incomeSourceOptions"
            ></VSelect>
          </VCol>
          <VCol cols="5">
            <VCurrency
              v-model.number="incomeSource.monthlyAmount"
              :rules="[rules.required]"
              :currency="props.currencyNow"
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
              :items="expenseCategories"
            ></VSelect>
          </VCol>
          <VCol cols="5">
            <VCurrency
              v-model.number="expense.amount"
              :rules="[rules.required]"
              :currency="props.currencyNow"
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
              :items="assetTypes"
            ></VSelect>
          </VCol>
          <VCol cols="5">
            <VCurrency
              v-model.number="asset.value"
              :rules="[rules.required]"
              :currency="props.currencyNow"
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
              :items="debtTypes"
            ></VSelect>
          </VCol>
          <VCol cols="3">
            <VCurrency
              v-model.number="debt.value"
              :rules="[rules.required]"
              :currency="props.currencyNow"
              label="Debt Value"
            ></VCurrency>
          </VCol>
          <VCol cols="3">
            <VCurrency
              v-model.number="debt.monthlyInstallment"
              :rules="[rules.required]"
              :currency="props.currencyNow"
              label="Monthly Installment"
            ></VCurrency>
          </VCol>
          <VCol cols="2">
            <VTextField
              v-model.number="debt.dueDate"
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

    <VBtn @click="fillDummy" class="my-2 mt-10" variant="flat" color="black"
      >Fill Dummy Data</VBtn
    >
  </div>
</template>
