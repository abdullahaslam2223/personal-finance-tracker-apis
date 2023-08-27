<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Category;
use App\Models\Transaction;

class BudgetController extends BaseController
{
    public function getBudget() {
        $user_id = auth()->user()->id;
        $total_amount = Category::where('user_id', $user_id)->sum('budget');
        $total_expenses = Transaction::where('user_id', $user_id)->where('is_income', 0)->sum('amount');
        $remaining_amount = $total_amount - $total_expenses;
        $response = [
            'amount' => $remaining_amount,
            'total_amount' => intval($total_amount)
        ];
        return ['data' => $response];
    }
}
