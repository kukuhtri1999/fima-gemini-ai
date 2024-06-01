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
    public function chat(Request $request){

        // $response = Gemini::models()->list();
        // dd($response->models);

        // Collect client data from the request
        $clientData = [
            'ask' => $request->input('ask'),
            'situation' => $request->input('situation'),
            'financialGoals' => $request->input('financialGoals'),
            'riskScale' => $request->input('riskScale'),
            'income' => $request->input('income'),
            'expenses' => $request->input('expenses'),
            'investment' => $request->input('investment'),
            'priority' => $request->input('priority'),
            'preference' => $request->input('preference'),
        ];



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

        I need high detailed of financial advise for this person. I will split it into 5 part of document one by one on the next chat , just wait for it for now.
        ";

        $prompt1 = " Continuing our last chat. please generate part of financial advice document :

        1. Executive Summary: Concise overview of the client's financial situation, goals, and key recommendations, tailored to the client's preferred language. Client will never forgive us if theres any incorrect data or calculations.

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

        $prompt2 = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        2. Financial Snapshot: Detailed analysis of income, expenses, assets, liabilities, and net worth, utilizing tables where appropriate for clear presentation ( please add an simulation table or related with correct calculations number for all of these) . If client doesnt put detail price or number on some of their things , just estimate those thing based on the latest standard market price of those things at the country of place where this client lived( also dont forget to put 'estimated' note) please also add simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.


        ";

        $prompt3 = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        3. Goal Analysis: Assessment of each goal's feasibility, considering the client's current situation, risk tolerance, and time horizon. ( please add an simulation table or related with correct calculations number for all of these). Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $prompt4 = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        4. Recommended Action Plan:
            * Budgeting Strategies: Tailored recommendations to optimize income and expenses, potentially using tables to illustrate budgets.
            * Investment Portfolio: Specific investment allocations aligned with risk tolerance and goals, including asset classes, funds, or individual stocks, with detailed explanations.
            * Debt Management Plan: Strategies for reducing or eliminating debt, potentially with tables showing repayment scenarios.
            * Tax Optimization: Potential tax-saving opportunities based on the client's situation and local tax regulations.
            * Insurance Considerations: Evaluation of insurance needs and recommendations for coverage, specific to the client's circumstances.
            * Estate Planning: Suggestions for wills, trusts, or other estate planning tools if relevant, considering local legal requirements.
            * estimated investment return and total money we got per year detailed in simulation table with correct calculation


            please also add budgeting, investment per year, debt management, tax , insurence, estate planning  simulation in a table with high detailed plan and correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $prompt5 = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        5. Monitoring and Review: Timeline for reviewing and adjusting the financial plan, emphasizing the importance of regular check-ins. please also add simulation in a table with high detailed plan with correct calculations number. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        $prompt6 = " Continuing our last chat. please generate part of financial advice document  (at least 4000 words) :

        6. Conclusion of all our previous parts with high detailed words and make sure clients clearly can understand it easily. Please make sure all the calculations numbers (including inside the tables) are correct and there are no errors. Client will never forgive us if theres any incorrect data or calculations.

        ";

        // dd($prompt);

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

        $chat1 = $chat->sendMessage($prompt1);
        $result1 = $chat1->text();

        $chat2 = $chat->sendMessage($prompt2);
        $result2 = $chat2->text();

        $chat3 = $chat->sendMessage($prompt3);
        $result3 = $chat3->text();

        $chat4 = $chat->sendMessage($prompt4);
        $result4 = $chat4->text();

        $chat5 = $chat->sendMessage($prompt5);
        $result5 = $chat5->text();

        $chat6 = $chat->sendMessage($prompt6);
        $result6 = $chat6->text();


        // Return the response to the Inertia view
        // return Inertia::render('Homepage', ['result' => $chatResult]);
        return Inertia::render('Homepage', ['result1' => $result1, 'result2' => $result2, 'result3' => $result3, 'result4' => $result4, 'result5' => $result5, 'result6' => $result6]);
    }
}
