<?php
require_once 'app/core/Controller.php';
require_once 'app/models/Expense.php';
require_once 'app/models/User.php';
require_once 'app/utils/Validation.php';
require_once 'app/enums/Category.php';
require_once 'app/controllers/DashboardController.php';
require_once 'config.php';

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
                'id' => $id,
                'category' => Category::CATEGORY[$expense->category],
                'description' => $expense->description,
                'amount' => $expense->amount,
                'image' => Category::ICONS[$expense->category],
                'location' => $expense->location,
                'created_at' => $expense->created_at,
                'updated_at' => $expense->updated_at,
                'user_id' => $expense->user_id,
                'first_name' =>  $_SESSION['first_name'],
                'last_name' =>  $_SESSION['last_name'],
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function createForm()
    {
        try {
            $user = User::find($_SESSION['user_id']);
            $this->view('create', [
                'user' => $user,
                'first_name' =>  $_SESSION['first_name'],
                'last_name' =>  $_SESSION['last_name'],
            ]);
            return;
        } catch (Exception $e) {
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
                    'first_name' =>  $_SESSION['first_name'],
                    'last_name' =>  $_SESSION['last_name'],
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
            // $this->show($expense_id);
            header("Location: " . "expense/{$expense_id}");
            return;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editForm($id)
    {
        try {
            $expense = Expense::find($id);

            if ($expense === null) {
                return $this->view('404', []);
            }

            $this->view('update', [
                'expense_id' => $id,
                'category' => $expense->category,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'image' => Category::ICONS[$expense->category],
                'location' => $expense->location,
                'created_at' => $expense->created_at,
                'updated_at' => $expense->updated_at,
                'user_id' => $expense->user_id,
                'first_name' =>  $_SESSION['first_name'],
                'last_name' =>  $_SESSION['last_name'],
            ]);

            return;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update($id)
    {
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

            // $this->show($id);
            header("Location: " . DIRECTION_URL . "expense/{$id}");
            return;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delete($id)
    {
        $expense = Expense::find($id);

        if ($expense === null) {
            return $this->view('404', []);
        }

        Expense::delete($id);
        return;
    }
}
