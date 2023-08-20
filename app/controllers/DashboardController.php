<?php
require_once 'app/core/Controller.php';
require_once 'app/models/Expense.php';
require_once 'app/enums/Category.php';

class DashboardController extends Controller
{
    public function show()
    {
        $userExpense = Expense::where(['user_id' => $_SESSION['user_id']]);
        $income = 0;
        $spending = 0;
        foreach ($userExpense as $item) {
            if ($item['amount'] > 0) $income += $item['amount'];
            if ($item['amount'] < 0) $spending -= $item['amount'];
        }
        $expense = array_map(function ($item) {
            $item['image'] = Category::ICONS[$item['category']];
            $item['category'] = Category::CATEGORY[$item['category']];
            return $item;
        }, $userExpense);

        $this->view('dashboard', [
            'last_name' => $_SESSION['last_name'],
            'first_name' => $_SESSION['first_name'],
            'income' => $income,
            'spending' => $spending,
            'expense' => $expense
        ]);
    }
}
