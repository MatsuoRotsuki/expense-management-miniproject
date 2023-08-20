<?php
require_once 'app/core/Controller.php';
require_once 'app/models/Expense.php';
require_once 'app/models/User.php';
require_once 'app/utils/Validation.php';
require_once 'app/enums/Category.php';

class ExpenseController extends Controller
{
    public function show($id)
    {
        try {
            $expense = Expense::find($id);

            if ($expense === null) {
                return $this->view('404', []);
            }

            $this->view('detail', [
                'category' => Category::getKeyFromValue($expense->category),
                'description' => $expense->description,
                'amount' => $expense->amount,
                'image' => $expense->image,
                'location' => $expense->location,
                'created_at' => $expense->created_at,
                'updated_at' => $expense->updated_at,
                'user_id' => $expense->user_id,
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function createForm() {
        try {
            $user = User::find($_SESSION['user_id']);
            $this->view('create', [
                'user' => $user,
            ]);
            return;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function store()
    {
        try {
            //Validation
            $errors = Validation::validate($_POST, [
                'description' => 'required|min:4|max:255',
                'amount' => 'required|numeric|min:1|max:24',
                'location' => 'max:255',
                'category' => 'numeric',
            ]);

            if (count($errors) > 0) {
                $this->view('create', [
                    'errors' => $errors,
                ]);
                return;
            }

            $expense = Expense::create([
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'amount' => $_POST['amount'],
                'location' => $_POST['location'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_id' => $_SESSION['user_id'],
            ]);

            $expense_id = $expense['id'];
            $this->show($expense_id);
            return;

        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function editForm($id) {
        try {
            $user_id = $_SESSION['user_id'];
            $user = User::find($user_id);

            $expense = Expense::find($id);

            if ($expense === null) {
                return $this->view('404', []);
            }

            $this->view('update', [
                'user' => $user,
                'expense_id' => $id,
                'category' => $expense->category,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'image' => $expense->image,
                'location' => $expense->location,
                'created_at' => $expense->created_at,
                'updated_at' => $expense->updated_at,
                'user_id' => $expense->user_id,
            ]);

            return;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function update($id) {
        try {
            $errors = Validation::validate($_POST, [
                'description' => 'required|min:4|max:255',
                'amount' => 'required|numeric|min:1|max:24',
                'location' => 'max:255',
                'category' => 'numeric',
            ]);

            if (count($errors) > 0) {
                $this->view('update', [
                    'errors' => $errors,
                ]);
                return;
            }

            Expense::update($id, [
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'amount' => $_POST['amount'],
                'location' => $_POST['location'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $this->show($id);
            return;

        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
