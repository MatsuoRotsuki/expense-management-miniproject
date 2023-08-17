<?php
require_once 'app/core/Controller.php';
require_once 'app/models/Expense.php';

class ExpenseController extends Controller
{
    public function get($id)
    {
        // get expense by id...

        $this->view('detail', ['id' => $id]);
    }
}
