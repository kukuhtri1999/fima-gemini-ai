<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Inertia\Inertia;
use Gemini\Data\Content;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomepageController extends Controller
{
    //
    public function chat(Request $request)
    {

        // dd($request->all());
        // $response = Gemini::models()->list();
        // dd($response->models);
        // dd($request);
        // Validate the request
        $validated = $request->validate([
            'ask' => 'required|string',
            'situation' => 'required|string',
            'financialGoals' => 'required|string',
            'riskScale' => 'required|integer|between:1,10',
            'income' => 'required|string',
            'expenses' => 'required|string',
            'investment' => 'required|string',
            'priority' => 'required|string',
            'preference' => 'required|string',
        ]);

        // Collect client data from the request
        $clientData = [
            'ask' => $validated['ask'],
            'situation' => $validated['situation'],
            'financialGoals' => $validated['financialGoals'],
            'riskScale' => $validated['riskScale'],
            'income' => $validated['income'],
            'expenses' => $validated['expenses'],
            'investment' => $validated['investment'],
            'priority' => $validated['priority'],
            'preference' => $validated['preference']
        ];

        // Collect client data from the request
        // $clientData = $request->only([
        //     'ask', 'situation', 'financialGoals', 'riskScale',
        //     'income', 'expenses', 'investment', 'priority', 'preference'
        // ]);


        // Format the prompt
        $prompt = "
        You are an expert financial advisor fluent in multiple languages. Analyze the following client information and generate a detailed financial advice document in the client's preferred language:

        Client Responses:
        1. Tell me whats your financial problem or what financial advise that you need ?: {$clientData['ask']}
        2. Tell me whats your name, age, where do you live, martial status, how many child you have ( and age of each child ) : {$clientData['situation']}
        3. Tell me your top 3 financial goals and when you want to achieve these goals : {$clientData['financialGoals']}
        4. On a scale of 1 to 10, how comfortable are you with taking risks in your investments? (1-10): {$clientData['riskScale']}
        5. What are your primary sources of income and their approximate monthly amounts after taxes? : {$clientData['income']}
        6. What are your major monthly expenses, including any outstanding debts? : {$clientData['expenses']}
        7. What are your current savings and investments, including approximate values? : {$clientData['investment']}
        8. What are your top financial priorities right now? : {$clientData['priority']}
        9. Do you have any specific investment preferences or restrictions? : {$clientData['preference']}

        I need high detailed of financial advise for this person. I will split it into 5 big BAB part of document one by one on the next chat , just wait for it for now.
        ";

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

        i will split this BAB into 3 SUBBAB , for now please generate BAB 2.1 : Income and Expense Statement: A table detailing the client's income sources and all categories of expenses, showing their net cash flow. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.


        ";

        $chatprompt[2] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate BAB 2.2 : Net Worth Statement: A table summarizing the client's assets (what they own) and liabilities (what they owe), resulting in their net worth. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[3] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate BAB 2.3 : Key financial ratios (e.g., debt-to-income, savings rate) that provide insights into the client's financial health. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[4] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        BAB 3. Goal Analysis: Assessment of each goal's feasibility, considering the client's current situation, risk tolerance, and time horizon.

        i will split this BAB into 2 SUBBAB , for now please generate BAB 3.1 : Goals Overview and Priorittization: A list of the client's short-term, mid-term, and long-term financial goals. Also Ranking of the goals based on importance and urgency. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[5] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate BAB 3.2 : Goal Feasibility and Specific Strategies: Assessment of each goal's attainability based on the client's financial resources and time horizon.
        Also Initial recommendations on how to approach each goal. If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note). please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[6] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        4. Recommended Action Plan:
            * Budgeting Strategies: Tailored recommendations to optimize income and expenses, potentially using tables to illustrate budgets.
            * Investment Portfolio: Specific investment allocations aligned with risk tolerance and goals, including asset classes, funds, or individual stocks, with detailed explanations.
            * Debt Management Plan: Strategies for reducing or eliminating debt, potentially with tables showing repayment scenarios.
            * Tax Optimization: Potential tax-saving opportunities based on the client's situation and local tax regulations.
            * Insurance Considerations: Evaluation of insurance needs and recommendations for coverage, specific to the client's circumstances.
            * Estate Planning: Suggestions for wills, trusts, or other estate planning tools if relevant, considering local legal requirements.
            * estimated investment return and total money we got per year detailed in simulation table with correct calculation


            i will split this BAB into 3 SUBBAB , for now please generate

            BAB 4.1 Cash Flow Management & Investment Planning:
            - Budgeting: Creation of a detailed budget to track income and expenses.
            - Debt Management: Strategies for paying down high-interest debt and optimizing debt management.
            - Emergency Fund: Recommendations for building an emergency fund to cover unexpected expenses.
            - Investment Policy Statement (IPS): A document outlining the client's investment goals, risk tolerance, time horizon, asset allocation, and investment philosophy.
            - Asset Allocation: Recommended allocation of investments across different asset classes (e.g., stocks, bonds, real estate).
            - Investment Selection: Specific recommendations for investment products (e.g., mutual funds, ETFs, individual stocks) based on the client's IPS.

            please also create 3 different planning that on point with this (also with simulation table)

             please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[7] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate :

            BAB 4.2 Tax and Insurance Planning:
            - Tax Efficiency: Strategies to minimize taxes through tax-advantaged accounts, deductions, and credits.
            - Tax Projections: Estimates of future tax liability based on the client's income and investments.
            - Insurence Risk Assessment: Identification of potential risks the client faces (e.g., disability, illness, death).
            - Insurance Coverage: Recommendations for adequate life, health, disability, and property/casualty insurance coverage.

            please also create 3 different planning that on point with this with detailed informations and plan data (also with simulation table)

             please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[8] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        Now please generate :

            BAB 4.3 Estate, Retirement, and Education Planning:
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

        $chatprompt[9] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        5. Monitoring and Review:
        - Review Schedule: A timeline for regular reviews of the financial plan to ensure it remains relevant and effective.
        - Contingency Planning: Discussion of potential risks and how to adjust the plan if circumstances change.

        please also add simulation in a table with high detailed plan with correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $chatprompt[10] = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

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
    }
}
