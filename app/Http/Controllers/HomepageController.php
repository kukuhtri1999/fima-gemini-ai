<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Inertia\Inertia;
use Gemini\Data\Content;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomepageController extends Controller
{
    //

    private function validateRequest(Request $request)
    {
        // Base validation rules
        $rules = [
            'field1.fullName' => 'required|string',
            'field1.age' => 'required|integer',
            'field1.gender' => 'required|string',
            'field1.martialStatus' => 'required|string',
            'field1.numberOfChildren' => 'required|integer',
            'field1.country' => 'required|string',
            'field1.city' => 'required|string',
            'field1.employmentStatus' => 'required|string',
            'field1.industry' => 'required|string',

            'field2.currency.value' => 'required|string',
            'field2.financialGoal' => 'required|string',
            'field2.riskScale' => 'required|integer|between:1,10',

            'field3.incomeSources' => 'required|array',
            'field3.incomeSources.*.source' => 'required|string',
            'field3.incomeSources.*.monthlyAmount' => 'required|numeric',
            'field3.monthlyExpenses' => 'required|array',
            'field3.monthlyExpenses.*.category' => 'required|string',
            'field3.monthlyExpenses.*.amount' => 'required|numeric',
            'field3.assets' => 'required|array',
            'field3.assets.*.type' => 'required|string',
            'field3.assets.*.value' => 'required|numeric',
            'field3.debts' => 'required|array',
            'field3.debts.*.type' => 'required|string',
            'field3.debts.*.amount' => 'required|numeric',
            'field3.debts.*.dueDate' => 'required|integer',
            'field3.debts.*.monthlyInstallment' => 'required|numeric',

            'field4.investmentPreferences' => 'required|array',
            'field4.investmentRestrictions' => 'required|array',
            'field4.insuranceCoverage' => 'required|array',
            'field4.additionalConcerns' => 'required|string',
        ];

        // Custom conditional validation
        $validator = Validator::make($request->all(), $rules, $this->customMessages());

        $conditionalRules = [
            'Retirement Planning' => [
                'field2.retirementAge' => 'required|integer',
                'field2.retirementLifestyle' => 'required|string',
                'field2.retirementLocation' => 'required|string',
                'field2.retirementActivities' => 'required|string',
                'field2.retirementIncome' => 'required|numeric',
                'field2.existingRetirementAccounts' => 'required|string',
                'field2.existingRetirementAccountsBalance' => 'required|numeric',
                'field2.socialSecurityIncome' => 'required|numeric',
            ],
            'Buying a Home' => [
                'field2.targetHomePrice' => 'required|numeric',
                'field2.downPaymentPercentage' => 'required|numeric',
                'field2.homeYears' => 'required|integer',
                'field2.firstTimeBuyer' => 'required|boolean',
            ],
            'Childrens Education' => [
                'field2.children' => 'required|array',
                'field2.consideringFinancialAid' => 'required|string',
            ],
            'Debt Reduction' => [
                'field2.debtTypes' => 'required|array',
                'field2.debtBalances' => 'required|numeric',
                'field2.debtInterestRates' => 'required|numeric',
                'field2.debtMinPayments' => 'required|numeric',
                'field2.debtPayoffTimeframe' => 'required|integer',
            ],
            'Emergency Fund' => [
                'field2.emergencyFundMonths' => 'required|integer',
                'field2.monthlyExpenses' => 'required|numeric',
                'field2.emergencyFundAccount' => 'required|string',
            ],
            'Starting a Business' => [
                'field2.businessType' => 'required|string',
                'field2.startupCosts' => 'required|numeric',
                'field2.operatingExpenses' => 'required|numeric',
                'field2.businessFinancing' => 'required|string',
                'field2.businessLaunchTimeframe' => 'required|integer',
            ],
            'Travel' => [
                'field2.travelDestinations' => 'required|string',
                'field2.travelFrequency' => 'required|string',
                'field2.travelBudget' => 'required|numeric',
                'field2.nextTripTimeframe' => 'required|integer',

            ],
            'Buy Something' => [
                'field2.buySomethingText' => 'required|string',
                'field2.buySomethingPrice' => 'required|numeric',

            ],
        ];

        // Apply the conditional rules
        foreach ($conditionalRules as $goal => $rules) {
            foreach ($rules as $field => $rule) {
                $validator->sometimes($field, $rule, function ($input) use ($goal) {
                    return $input->field2['financialGoal'] === $goal;
                });
            }
        }

        // Validate the request
        return $validator->validate();
    }

    private function customMessages()
    {
        return [
            'field1.fullName.required' => 'Full Name is required',
            'field1.age.required' => 'Age is required',
            'field1.gender.required' => 'Gender is required',
            'field1.martialStatus.required' => 'Marital Status is required',
            'field1.numberOfChildren.required' => 'Number of Children is required',
            'field1.country.required' => 'Country is required',
            'field1.city.required' => 'City is required',
            'field1.employmentStatus.required' => 'Employment Status is required',
            'field1.industry.required' => 'Industry is required',

            'field2.currency.value.required' => 'Currency is required',
            'field2.financialGoal.required' => 'Financial Goal is required',
            'field2.retirementAge.required' => 'Retirement Age is required',
            'field2.retirementAge.integer' => 'Retirement Age must be an integer',
            'field2.retirementLifestyle.required' => 'Retirement Lifestyle is required',
            'field2.retirementLocation.required' => 'Retirement Location is required',
            'field2.retirementActivities.required' => 'Retirement Activities are required',
            'field2.retirementIncome.required' => 'Retirement Income is required',
            'field2.retirementIncome.numeric' => 'Retirement Income must be a number',
            'field2.existingRetirementAccounts.required' => 'Existing Retirement Accounts information is required',
            'field2.existingRetirementAccountsBalance.required' => 'Existing Retirement Accounts Balance is required',
            'field2.existingRetirementAccountsBalance.numeric' => 'Existing Retirement Accounts Balance must be a number',
            'field2.socialSecurityIncome.required' => 'Social Security Income is required',
            'field2.socialSecurityIncome.numeric' => 'Social Security Income must be a number',
            'field2.targetHomePrice.required' => 'Target Home Price is required',
            'field2.targetHomePrice.numeric' => 'Target Home Price must be a number',
            'field2.downPaymentPercentage.required' => 'Down Payment Percentage is required',
            'field2.downPaymentPercentage.numeric' => 'Down Payment Percentage must be a number',
            'field2.homeYears.required' => 'Number of years to buy a home is required',
            'field2.homeYears.integer' => 'Number of years to buy a home must be an integer',
            'field2.firstTimeBuyer.required' => 'First Time Buyer information is required',
            'field2.firstTimeBuyer.boolean' => 'First Time Buyer must be a boolean value',
            'field2.children.required' => 'Children information is required',
            'field2.children.array' => 'Children information must be an array',
            'field2.consideringFinancialAid.required' => 'Considering Financial Aid information is required',
            'field2.debtTypes.required' => 'Debt Types are required',
            'field2.debtTypes.array' => 'Debt Types must be an array',
            'field2.debtBalances.required' => 'Debt Balances are required',
            'field2.debtBalances.numeric' => 'Debt Balances must be a number',
            'field2.debtInterestRates.required' => 'Debt Interest Rates are required',
            'field2.debtInterestRates.numeric' => 'Debt Interest Rates must be a number',
            'field2.debtMinPayments.required' => 'Debt Minimum Payments are required',
            'field2.debtMinPayments.numeric' => 'Debt Minimum Payments must be a number',
            'field2.debtPayoffTimeframe.required' => 'Debt Payoff Timeframe is required',
            'field2.debtPayoffTimeframe.integer' => 'Debt Payoff Timeframe must be an integer',
            'field2.emergencyFundMonths.required' => 'Emergency Fund Months are required',
            'field2.emergencyFundMonths.integer' => 'Emergency Fund Months must be an integer',
            'field2.monthlyExpenses.required' => 'Monthly Expenses are required',
            'field2.monthlyExpenses.numeric' => 'Monthly Expenses must be a number',
            'field2.emergencyFundAccount.required' => 'Emergency Fund Account information is required',
            'field2.businessType.required' => 'Business Type is required',
            'field2.startupCosts.required' => 'Startup Costs are required',
            'field2.startupCosts.numeric' => 'Startup Costs must be a number',
            'field2.operatingExpenses.required' => 'Operating Expenses are required',
            'field2.operatingExpenses.numeric' => 'Operating Expenses must be a number',
            'field2.businessFinancing.required' => 'Business Financing information is required',
            'field2.businessLaunchTimeframe.required' => 'Business Launch Timeframe is required',
            'field2.businessLaunchTimeframe.integer' => 'Business Launch Timeframe must be an integer',
            'field2.travelDestinations.required' => 'Travel Destinations are required',
            'field2.travelFrequency.required' => 'Travel Frequency is required',
            'field2.travelBudget.required' => 'Travel Budget is required',
            'field2.travelBudget.numeric' => 'Travel Budget must be a number',
            'field2.nextTripTimeframe.required' => 'Next Trip Timeframe is required',
            'field2.nextTripTimeframe.integer' => 'Next Trip Timeframe must be an integer',
            'field2.buySomethingText.required' => 'Buy Something Text is required',
            'field2.buySomethingPrice.required' => 'Buy Something Price is required',
            'field2.buySomethingPrice.numeric' => 'Buy Something Price must be a number',
            'field2.riskScale.required' => 'Risk Scale is required',
            'field2.riskScale.between' => 'Risk Scale must be between 1 and 10',


            'field3.incomeSources.required' => 'Income Sources are required',
            'field3.incomeSources.*.source.required' => 'Income Source is required',
            'field3.incomeSources.*.monthlyAmount.required' => 'Income Source Monthly Amount is required',
            'field3.monthlyExpenses.required' => 'Monthly Expenses are required',
            'field3.monthlyExpenses.*.category.required' => 'Monthly Expense Category is required',
            'field3.monthlyExpenses.*.amount.required' => 'Monthly Expense Amount is required',
            'field3.assets.required' => 'Assets are required',
            'field3.assets.*.type.required' => 'Asset Type is required',
            'field3.assets.*.value.required' => 'Asset Value is required',
            'field3.debts.required' => 'Debts are required',
            'field3.debts.*.type.required' => 'Debt Type is required',
            'field3.debts.*.amount.required' => 'Debt Amount is required',
            'field3.debts.*.dueDate.required' => 'Debt Due Date is required',
            'field3.debts.*.monthlyInstallment.required' => 'Debt Monthly Installment is required',
            'field4.investmentPreferences.required' => 'Investment Preferences are required',
            'field4.investmentRestrictions.required' => 'Investment Restrictions are required',
            'field4.insuranceCoverage.required' => 'Insurance Coverage is required',
            'field4.additionalConcerns.required' => 'Additional Concerns are required',
        ];
    }

    protected function collectClientData(array $validated): array
    {
        $clientData = [
            'fullName' => $validated['field1']['fullName'],
            'age' => $validated['field1']['age'],
            'gender' => $validated['field1']['gender'],
            'martialStatus' => $validated['field1']['martialStatus'],
            'numberOfChildren' => $validated['field1']['numberOfChildren'],
            'country' => $validated['field1']['country'],
            'city' => $validated['field1']['city'],
            'employmentStatus' => $validated['field1']['employmentStatus'],
            'industry' => $validated['field1']['industry'],
            'currency' => $validated['field2']['currency']['value'],
            'financialGoal' => $validated['field2']['financialGoal'],
            'riskScale' => $validated['field2']['riskScale'],
            'incomeSources' => $validated['field3']['incomeSources'],
            'monthlyExpenses' => $validated['field3']['monthlyExpenses'],
            'assets' => $validated['field3']['assets'],
            'debts' => $validated['field3']['debts'],
            'investmentPreferences' => $validated['field4']['investmentPreferences'],
            'investmentRestrictions' => $validated['field4']['investmentRestrictions'],
            'insuranceCoverage' => $validated['field4']['insuranceCoverage'],
            'additionalConcerns' => $validated['field4']['additionalConcerns'],
        ];

        switch ($validated['field2']['financialGoal']) {
            case 'Retirement Planning':
                $clientData = array_merge($clientData, [
                    'retirementAge' => $validated['field2']['retirementAge'],
                    'retirementLifestyle' => $validated['field2']['retirementLifestyle'],
                    'retirementLocation' => $validated['field2']['retirementLocation'],
                    'retirementActivities' => $validated['field2']['retirementActivities'],
                    'retirementIncome' => $validated['field2']['retirementIncome'],
                    'existingRetirementAccounts' => $validated['field2']['existingRetirementAccounts'],
                    'existingRetirementAccountsBalance' => $validated['field2']['existingRetirementAccountsBalance'],
                    'socialSecurityIncome' => $validated['field2']['socialSecurityIncome'],
                ]);
                break;

            case 'Buying a Home':
                $clientData = array_merge($clientData, [
                    'targetHomePrice' => $validated['field2']['targetHomePrice'],
                    'downPaymentPercentage' => $validated['field2']['downPaymentPercentage'],
                    'homeYears' => $validated['field2']['homeYears'],
                    'firstTimeBuyer' => $validated['field2']['firstTimeBuyer'],
                ]);
                break;

            case 'Childrens Education':
                $clientData = array_merge($clientData, [
                    'children' => $validated['field2']['children'],
                    'consideringFinancialAid' => $validated['field2']['consideringFinancialAid'],
                ]);
                break;

            case 'Debt Reduction':
                $clientData = array_merge($clientData, [
                    'debtTypes' => $validated['field2']['debtTypes'],
                    'debtBalances' => $validated['field2']['debtBalances'],
                    'debtInterestRates' => $validated['field2']['debtInterestRates'],
                    'debtMinPayments' => $validated['field2']['debtMinPayments'],
                    'debtPayoffTimeframe' => $validated['field2']['debtPayoffTimeframe'],
                ]);
                break;

            case 'Emergency Fund':
                $clientData = array_merge($clientData, [
                    'emergencyFundMonths' => $validated['field2']['emergencyFundMonths'],
                    'monthlyExpenses' => $validated['field2']['monthlyExpenses'],
                    'emergencyFundAccount' => $validated['field2']['emergencyFundAccount'],
                ]);
                break;

            case 'Starting a Business':
                $clientData = array_merge($clientData, [
                    'businessType' => $validated['field2']['businessType'],
                    'startupCosts' => $validated['field2']['startupCosts'],
                    'operatingExpenses' => $validated['field2']['operatingExpenses'],
                    'businessFinancing' => $validated['field2']['businessFinancing'],
                    'businessLaunchTimeframe' => $validated['field2']['businessLaunchTimeframe'],
                ]);
                break;

            case 'Travel':
                $clientData = array_merge($clientData, [
                    'travelDestinations' => $validated['field2']['travelDestinations'],
                    'travelFrequency' => $validated['field2']['travelFrequency'],
                    'travelBudget' => $validated['field2']['travelBudget'],
                    'nextTripTimeframe' => $validated['field2']['nextTripTimeframe'],
                ]);
                break;

            case 'Buy Something':
                $clientData = array_merge($clientData, [
                    'buySomethingText' => $validated['field2']['buySomethingText'],
                    'buySomethingPrice' => $validated['field2']['buySomethingPrice'],
                ]);
                break;
        }

        return $clientData;
    }

    protected function generateFinancialGoalPrompt(array $clientData): string
    {
        $financialGoalPrompt = '';

        switch ($clientData['financialGoal']) {
            case 'Retirement Planning':
                $financialGoalPrompt = "
            At what age do you plan to retire? {$clientData['retirementAge']}
            What kind of lifestyle do you envision in retirement?? {$clientData['retirementLifestyle']}
            Where do you plan to live during retirement? {$clientData['retirementLocation']}
            What activities or hobbies do you want to pursue in during retirement? {$clientData['retirementActivities']}
            What is your income per month do you estimate you'll need to maintain your desired lifestyle? {$clientData['currency']} {$clientData['retirementIncome']}
            Do you have any existing retirement accounts (e.g., 401k, IRA)? {$clientData['existingRetirementAccounts']}
            What is the balance of your existing retirement accounts? {$clientData['currency']} {$clientData['existingRetirementAccountsBalance']}
            What is your estimated Social Security or pension income per Month ? {$clientData['currency']} {$clientData['socialSecurityIncome']}
            ";
                break;

            case 'Buying a Home':
                $financialGoalPrompt = "
            What is the target price of the home you wish to buy? {$clientData['currency']} {$clientData['targetHomePrice']}
            What percentage of the down payment do you plan to make? {$clientData['downPaymentPercentage']} %
            When would you like to purchase a home (in years)? {$clientData['homeYears']} years
            Are you a first-time homebuyer? {$clientData['firstTimeBuyer']}
            ";
                break;

            case 'Childrens Education':
                $childrenCount = count((array)$clientData['children']);
                $childrenPrompt = '';
                foreach ($clientData['children'] as $index => $child) {
                    $childNumber = $index + 1;
                    $childrenPrompt .= "
                        Child {$childNumber}:
                        Age: {$child['age']}
                        Education Type: " . implode(', ', $child['educationType']) . "
                        Estimated Annual Cost: {$clientData['currency']} {$child['estimatedAnnualCost']}
                        ";
                }

                $financialGoalPrompt = "
                    How many children do you have? {$childrenCount}

                    Here are list of all my children:
                    {$childrenPrompt}

                    Are you considering financial aid for your children's education? {$clientData['consideringFinancialAid']}
                    ";
                break;

            case 'Debt Reduction':
                $financialGoalPrompt = "
            What types of debt do you have? " . implode(', ', $clientData['debtTypes']) . "
            What is the total balance of your debts? {$clientData['currency']} {$clientData['debtBalances']}
            What are the interest rates on your debts? {$clientData['debtInterestRates']} %
            What is your minimum monthly payment for your debts? {$clientData['currency']} {$clientData['debtMinPayments']}
            What is your debt payoff timeframe or due date in months? {$clientData['debtPayoffTimeframe']} months
            ";
                break;

            case 'Emergency Fund':
                $financialGoalPrompt = "
            How many months of essential living expenses would you like your emergency fund to cover? {$clientData['emergencyFundMonths']} months
            What are your estimated monthly expenses? {$clientData['currency']} {$clientData['monthlyExpenses']}
            Where will you keep your emergency fund? {$clientData['emergencyFundAccount']}
            ";
                break;

            case 'Starting a Business':
                $financialGoalPrompt = "
            What type of business do you want to start? {$clientData['businessType']}
            What are the estimated startup costs for your business? {$clientData['currency']} {$clientData['startupCosts']}
            What are the estimated monthly operating expenses for your business? {$clientData['currency']} {$clientData['operatingExpenses']}
            How do you plan to finance your business? {$clientData['businessFinancing']}
            When do you plan to launch your business in months? {$clientData['businessLaunchTimeframe']} months
            ";
                break;

            case 'Travel':
                $financialGoalPrompt = "
            What are your desired travel destinations? {$clientData['travelDestinations']}
            How often do you plan to travel? {$clientData['travelFrequency']}
            What is your estimated travel budget? {$clientData['currency']} {$clientData['travelBudget']}
            When do you plan to take your next trip in months?  {$clientData['nextTripTimeframe']} months
            ";
                break;

            case 'Buy Something':
                $financialGoalPrompt = "
            What items do you want to buy? {$clientData['buySomethingText']}
            What is the estimated price of the items you want to buy? {$clientData['currency']} {$clientData['buySomethingPrice']}
            ";
                break;
        }

        return $financialGoalPrompt;
    }

    private function formatArrayData($data, $keys, $currency)
    {
        $formatted = "";
        foreach ($data as $item) {
            $formatted .= "    - ";
            foreach ($keys as $key) {
                if (in_array($key, ['amount', 'value', 'monthlyAmount', 'MonthlyInstallment'])) {
                    $formatted .= "{$key}: $currency {$item[$key]}, ";
                } else {
                    $formatted .= "{$key}: {$item[$key]}, ";
                }
            }
            $formatted = rtrim($formatted, ", ") . "\n";
        }
        return $formatted;
    }


    public function chat(Request $request)
    {

        try {

            // dd($request->all());
            // $response = Gemini::models()->list();
            // dd($response->models);
            // dd($request);
            // Validate the request
            $validated = $this->validateRequest($request);

            // Collect client data from the request
            $clientData = $this->collectClientData($validated);

            $financialGoalPrompt = $this->generateFinancialGoalPrompt($clientData);

            // dd($financialGoalPrompt);

            // Format the prompt
            //     $prompt = "
            // You are an expert financial advisor fluent in multiple languages. Analyze the following client information and generate a detailed financial advice document in the client's preferred language:

            // Client Responses:
            // 1. Tell me whats your financial problem or what financial advise that you need ?: {$clientData['ask']}
            // 2. Tell me whats your name, age, where do you live, martial status, how many child you have ( and age of each child ) : {$clientData['situation']}
            // 3. Tell me your top 3 financial goals and when you want to achieve these goals : {$clientData['financialGoals']}
            // 4. On a scale of 1 to 10, how comfortable are you with taking risks in your investments? (1-10): {$clientData['riskScale']}
            // 5. What are your primary sources of income and their approximate monthly amounts after taxes? : {$clientData['income']}
            // 6. What are your major monthly expenses, including any outstanding debts? : {$clientData['expenses']}
            // 7. What are your current savings and investments, including approximate values? : {$clientData['investment']}
            // 8. What are your top financial priorities right now? : {$clientData['priority']}
            // 9. Do you have any specific investment preferences or restrictions? : {$clientData['preference']}

            // I need high detailed of financial advise for this person. I will split it into 5 big BAB part of document one by one on the next chat , just wait for it for now.
            // ";

            $prompt = "
        You are an expert financial advisor fluent in multiple languages. Analyze the following client information and generate a detailed financial advice document in the client's preferred language:

        Client Information:
        1. Full Name: {$clientData['fullName']}
        2. Age: {$clientData['age']}
        3. Gender: {$clientData['gender']}
        4. Marital Status: {$clientData['martialStatus']}
        5. Number of Children: {$clientData['numberOfChildren']}
        6. Country: {$clientData['country']}
        7. City: {$clientData['city']}
        8. Employment Status: {$clientData['employmentStatus']}
        9. Industry: {$clientData['industry']}

        Financial Goal Information:
        10. Preferred Currency: {$clientData['currency']}
        11. Financial Goal: {$clientData['financialGoal']}
        12. Risk Tolerance (1-10): {$clientData['riskScale']}

        Additional FInancial Goal Informations:
        $financialGoalPrompt

        Financial Situation Income and Expenses:
        13. Income Sources:
        " . $this->formatArrayData($clientData['incomeSources'], ['source', 'monthlyAmount'], $clientData['currency']) . "
        14. Monthly Expenses:
        " . $this->formatArrayData($clientData['monthlyExpenses'], ['category', 'amount'], $clientData['currency']) . "
        15. Assets:
        " . $this->formatArrayData($clientData['assets'], ['type', 'value'], $clientData['currency']) . "
        16. Debts:
        " . $this->formatArrayData($clientData['debts'], ['type', 'amount', 'dueDate', 'monthlyInstallment'], $clientData['currency']) . "

        Additional Financial Information:
        17. Investment Preferences: " . implode(', ', $clientData['investmentPreferences']) . "
        18. Investment Restrictions: " . implode(', ', $clientData['investmentRestrictions']) . "
        19. Insurance Coverage: " . implode(', ', $clientData['insuranceCoverage']) . "
        20. Additional Financial Concerns: {$clientData['additionalConcerns']}

        I need a highly detailed financial but easy to understands advice for this person. I will split it into 5 main sections of the document one by one in the next chat, so please wait for further instructions.
        ";

            // dd($prompt);


            $chatprompt = null;
            $chatprompt[0] = " Continuing our last chat. please generate part of financial advice document :

        BAB 1. Executive Summary: Concise overview of the client's financial situation, goals, and key recommendations, tailored to the client's preferred language. Client will never forgive us if theres any incorrect data or calculations.

        Additional Instructions:
        * Prioritize clear, actionable, and personalized advice in the client's preferred language.
        * Explain financial concepts in simple terms, avoiding jargon.
        * Offer specific recommendations (e.g., percentage allocations for investments, debt repayment schedules).
        * Be realistic and consider potential risks or obstacles.
        * Provide resources or references where applicable, tailored to the client's location and language.
        * Aim for a detailed document length equivalent to 15-20 PDF pages or 200,000 words.
        * If the client's situation is too complex or incomplete, suggest seeking a human financial advisor for personalized assistance.
        * Use tables, charts, or graphs to enhance clarity and visual appeal where appropriate.
        ";


            $chatprompt[1] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        BAB 2. Financial Snapshot: Detailed analysis of income, expenses, assets, liabilities, and net worth, utilizing tables where appropriate for clear presentation ( please add an simulation table or related with correct calculations number for all of these) .

        i will split this BAB into 2 SUBBAB , for now please generate BAB 2.1 : Income and Expense Statement: A table detailing the client's income sources and all categories of expenses, showing their net cash flow. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.


        ";

            $chatprompt[2] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate BAB 2.2 : Net Worth Statement & Key financial ratios: A table summarizing the client's assets (what they own) and liabilities (what they owe), resulting in their net worth. also (e.g., debt-to-income, savings rate) that provide insights into the client's financial health. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

            $chatprompt[3] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        BAB 3. Goal Analysis: Assessment of each goal's feasibility, considering the client's current situation, risk tolerance, and time horizon.

        i will split this BAB into 2 SUBBAB , for now please generate BAB 3.1 : Goals Overview and Priorittization: A list of the client's short-term, mid-term, and long-term financial goals. Also Ranking of the goals based on importance and urgency. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

            $chatprompt[4] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate BAB 3.2 : Goal Feasibility and Specific Strategies: Assessment of each goal's attainability based on the client's financial resources and time horizon.
        Also Initial recommendations on how to approach each goal. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        please also create 3 different strategy planning that on point with this (also with simulation table)

        ";

            $chatprompt[5] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        4. Recommended Action Plan:
            * Budgeting Strategies: Tailored recommendations to optimize income and expenses, potentially using tables to illustrate budgets.
            * Investment Portfolio: Specific investment allocations aligned with risk tolerance and goals, including asset classes, funds, or individual stocks, with detailed explanations.
            * Debt Management Plan: Strategies for reducing or eliminating debt, potentially with tables showing repayment scenarios.
            * Tax Optimization: Potential tax-saving opportunities based on the client's situation and local tax regulations.
            * Insurance Considerations: Evaluation of insurance needs and recommendations for coverage, specific to the client's circumstances.
            * Estate Planning: Suggestions for wills, trusts, or other estate planning tools if relevant, considering local legal requirements.
            * estimated investment return and total money we got per year detailed in simulation table with correct calculation


            i will split this BAB into 3 SUBBAB , for now please generate

            BAB 4.1 Cash Flow Management & Investment Planning based on Client financial goals / financial problem / financial priorities :
            - Budgeting: Creation of a detailed budget to track income and expenses.
            - Debt Management: Strategies for paying down high-interest debt and optimizing debt management.
            - Emergency Fund: Recommendations for building an emergency fund to cover unexpected expenses.
            - Investment Policy Statement (IPS): A document outlining the client's investment goals, risk tolerance, time horizon, asset allocation, and investment philosophy.
            - Asset Allocation: Recommended allocation of investments across different asset classes (e.g., stocks, bonds, real estate).
            - Investment Selection: Specific recommendations for investment products (e.g., mutual funds, ETFs, individual stocks) based on the client's IPS.

            please also create 3 different planning that on point with this (also with simulation table)

             please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

            $chatprompt[6] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate :

            BAB 4.2 Tax and Insurance Planning based on Client financial goals / financial problem / financial priorities:
            - Tax Efficiency: Strategies to minimize taxes through tax-advantaged accounts, deductions, and credits.
            - Tax Projections: Estimates of future tax liability based on the client's income and investments.
            - Insurence Risk Assessment: Identification of potential risks the client faces (e.g., disability, illness, death).
            - Insurance Coverage: Recommendations for adequate life, health, disability, and property/casualty insurance coverage.

            please also create 3 different planning that on point with this with detailed informations and plan data (also with simulation table)

             please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

            $chatprompt[7] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate :

            BAB 4.3 Estate, Retirement, and Education Planning based on Client financial goals / financial problem / financial priorities:
            - Estate Wills and Trusts: Recommendations for creating or updating wills and trusts to ensure assets are distributed according to the client's wishes.
            - Estate Power of Attorney: Guidance on assigning power of attorney for financial and healthcare decisions.
            - Retirement Goals: Clarification of the client's retirement goals (e.g., desired lifestyle, income needs).
            - Retirement Projections: Estimates of retirement income based on savings, investments, and other income sources.
            - Retirement Strategies: Recommendations for saving and investing for retirement.
            - Education Goals: Identification of the client's education goals for themselves or their dependents.
            - Education Savings Plans: Recommendations for saving for education expenses (e.g., 529 plans).

            please also create 2 different planning that on point with this with detailed informations and plan data (also with simulation table)

             please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

            $chatprompt[8] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        5. Monitoring and Review:
        - Review Schedule: A timeline for regular reviews of the financial plan to ensure it remains relevant and effective.
        - Contingency Planning: Discussion of potential risks and how to adjust the plan if circumstances change.

        please also add simulation in a table with high detailed plan with correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

            $chatprompt[9] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        6. Conclusion of all our previous parts with high detailed words and make sure clients clearly can understand it easily. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";



            // Send the formatted prompt to the Gemini API
            // $result = Gemini::geminiPro()->streamGenerateContent($prompt);

            $chat = Gemini::chat()
                ->startChat(history: [
                    Content::parse(part: $prompt)
                ]);

            // // Collect the response
            // $chatResult = '';
            // foreach ($result as $response) {
            //     $chatResult .= $response->text();
            // }
            // $result = null;

            $result = array_map(function ($prompt) use ($chat) {
                return $chat->sendMessage($prompt)->text();
            }, $chatprompt);

            // dd($result);

            // Return the response to the Inertia view
            // return Inertia::render('Homepage', ['result' => $chatResult]);
            return response()->json(['result' => $result]);
        } catch (ValidationException $e) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
