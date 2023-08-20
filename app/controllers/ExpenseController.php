<?php
require_once 'app/core/Controller.php';
require_once 'app/models/Expense.php';

class ExpenseController extends Controller
{
    public function show($id)
    {
        $expense = Expense::where(['id' => $id]);

        if (count($expense) == 0) {
            $this->view('404');
            return;
        }

        $this->view('detail', [
            'id' => $id,
            'category' => $expense[0]['category'],
            'description' => $expense[0]['description'],
            'amount' => $expense[0]['amount'],
            'image' => $expense[0]['image'],
            'location' => $expense[0]['location'],
            'created_at' => $expense[0]['created_at'],
        ]);
    }
}
