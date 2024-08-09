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
                'field2.retirementLifestyle' => 'required',
                'field2.retirementLocation' => 'required|string',
                'field2.retirementActivities' => 'required|string',
                'field2.retirementIncome' => 'required|numeric',
                'field2.existingRetirementAccounts' => 'required',
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
                'field2.businessFinancing' => 'required',
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
            What kind of lifestyle do you envision in retirement?? " . implode(', ', $clientData['retirementLifestyle']) . "
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
            How do you plan to finance your business? " . implode(', ', $clientData['businessFinancing']) . "
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

            $validated = $this->validateRequest($request);

            // Collect client data from the request
            $clientData = $this->collectClientData($validated);

            $financialGoalPrompt = $this->generateFinancialGoalPrompt($clientData);

            $prompt = "
            You are an expert financial advisor fluent in multiple languages. Analyze the following client information and generate a detailed financial advice document in the {$clientData['country']} language:

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
            $chatprompt[0] = "
            $prompt

            Continuing our conversation, please generate Part 1 of the financial advice document with more than 2000 words:

            **BAB 1. Executive Summary:**
            * Provide a concise overview of the client's financial situation, goals, and key recommendations.
            * Tailor the language and financial advice to the  {$clientData['country']} context (using {$clientData['currency']}).
            * Highlight the client's strengths, weaknesses, opportunities, and threats.
            * Include a prioritized list of actionable steps.

            **Additional Instructions:**
            * Ensure accuracy in data and calculations.
            * Write in clear, easy-to-understand language, detailed, avoiding jargon.
            * Add links to explain any financial terms or concepts that may be unfamiliar to the client, such as [net worth](#), [cash flow](#), [risk tolerance](#), etc.
            ";


            $chatprompt[1] = "
            $prompt

            Continuing our conversation, please generate Part 2 of the financial advice document with more than 2000 words:

            **BAB 2. Financial Snapshot:**

            * **2.1 Income, Expense, Debt Statement:**  Create a detailed table showing income sources, expense categories, debt/liabilities monthly categories, and net cash flow. please make sure the calculations are corrects
            * **2.2 Net Worth Statement:** Create a table summarizing assets and liabilities to calculate net worth. please make sure the calculations are corrects
            * **2.3 Key Financial Ratios:** Calculate and explain relevant ratios like debt-to-income and savings rate. please make sure the calculations are corrects

            **Additional Instructions:**
            * Estimate missing values based on standard market prices in {$clientData['city']}, {$clientData['country']} if necessary.
            * Use tables and clear formatting for easy readability. amd make sure the calculations are correct
            * Ensure accuracy in data and calculations. Ensure all calculations are accurate and error-free.
            * All explanations must be detailed and using easy to understand language with links to relevant financial terms.
            * Lets assume that your client is someone who doesnt know anything about financial plan and financial terms, please explain all of these detailed and make your client fully understand every each of your words

            ";

            $chatprompt[2] = "
            $prompt

            Continuing our conversation, please generate Part 3 of the financial advice document, focusing only on the specific financial goals selected by the client with more than 2000 words:

            BAB 3. Goal Analysis:

            * 3.1 Goals Overview and Prioritization:
                * As you can see that the client answer of these question here (also please keep in mind) :
                $financialGoalPrompt

                * Based on the client's answer, we can prioritize the goals that are most important to the client.
            * 3.2 Goal Feasibility and Specific Strategies:
                * Assess the feasibility of each selected goal based on the client's financial resources, time horizon, and risk tolerance.
                * Provide tailored recommendations and action steps to help the client achieve each goal.
            * 3.3 Four Strategy Plans:
                * Develop four distinct strategies for achieving the selected goals, varying in levels of risk and potential outcomes. with detailed explanations
                * Present each strategy with few and full simulation table illustrating potential financial scenarios based on different assumptions and investment choices. with detailed explanations

            Additional Instructions:
            * Use only information relevant to the client's selected goals.
            * Provide actionable and specific strategies tailored to the {$clientData['country']} context and the client's financial situation.
            * Ensure accuracy in data and calculations. Use tables for clear presentation of financial simulations.
            * All explanations must be detailed and using easy to understand language
            * Add links to explain any financial terms or strategies mentioned.
            * Lets assume that your client is someone who doesnt know anything about financial plan and financial terms, please explain all of these detailed and make your client fully understand every each of your words

            ";

            $chatprompt[3] = " $prompt

            Continuing our conversation, please generate Part 4 of the financial advice document with more than 2000 words:

            **BAB 4. Recommended Action Plan:**

            * **4.1 Cash Flow Management & Investment Planning:** Offer detailed and easy to understand language of budgeting strategies, debt management plans, and investment recommendations based on the client's goals and risk tolerance. please also create 3 best recommendations plan options with data table simulations with detailed strategy and with detailed explanations until the financial goal reached
            * **4.2 Tax and Insurance Planning:** Suggest tax optimization strategies relevant to {$clientData['country']} and recommend appropriate insurance coverage based on the client's needs and risk profile. please also create 3 best recommendations plan options with data table simulations with detailed strategy and with detailed explanations until the financial goal reached
            * **4.3 Other Recommended Action Plan:** Provide detailed with some example simulations until the financial goals reached of additional financial planning recommendations tailored to the client's specific situation and goals based on this client financial goals :

            $financialGoalPrompt


            **Additional Instructions:**
            * Provide specific recommendations for investments, budgeting, debt repayment, etc.
            * Include tables to illustrate repayment scenarios, investment allocations, and projected outcomes.
            * Ensure all financial calculations are accurate and relevant to {$clientData['country']} . Ensure accuracy in data and calculations. client never forgive us if theres any incorrect data or calculations.
            * Lets assume that your client is someone who doesnt know anything about financial plan and financial terms, please explain all of these detailed and make your client fully understand every each of your words
            ";

            $chatprompt[4] = " $prompt

            Continuing our conversation, please generate the final part of the financial advice document with more than 2000 words:

            **BAB 5. Monitoring, Review, and Conclusion:**

            * **5.1 Monitoring and Review Schedule:** Outline a timeline for regular review and adjustments to the financial plan. with detailed explanations
            * **5.2 Contingency Planning:** Discuss potential risks and how to adapt the plan if circumstances change. with detailed explanations
            * **5.3 Conclusion:** Summarize the key findings and recommendations, emphasizing the importance of taking action and seeking professional guidance when needed. with detailed explanations

            **Additional Instructions:**
            * Reiterate the key points of the financial plan in clear and concise language.
            * Emphasize the ongoing nature of financial planning and the need for flexibility.
            * Offer encouragement and support to the client in their financial journey.
            * Include links to relevant financial terms or concepts that may be unfamiliar.
            * Lets assume that your client is someone who doesnt know anything about financial plan and financial terms, please explain all of these detailed and make your client fully understand every each of your words
            ";

            $chat = Gemini::chat()
                ->startChat(history: [
                    Content::parse(part: $prompt)
                ]);

            $result = array_map(function ($prompt) use ($chat) {
                return $chat->sendMessage($prompt)->text();
            }, $chatprompt);

            return response()->json(['result' => $result]);
        } catch (ValidationException $e) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
