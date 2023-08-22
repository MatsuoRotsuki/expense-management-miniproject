<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Moneykeeper</title>

    <!-- Custom Font -->
    <!-- font-family: 'Lato', sans-serif; -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel="icon" type="image/x-icon" href="public/icons/logo.svg">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#E5E5E5] w-full">
    <?php include 'app/views/layout/navbar.php' ?>

    <!-- Main container -->
    <div class="px-8 py-6 bg-white min-h-screen">
        <div class="flex flex-col w-full mt-[80px]">

            <!-- Income, Expense, Balance -->
            <div class="grid grid-cols-3 gap-8 h-[160px]">

                <div class="h-[160px] bg-green-500 rounded-xl shadow-lg p-5 flex items-center">
                    <div class="p-3 rounded-[50%] border-black border-2 bg-white m-5">
                        <img src="./public/icons/income.svg" width="76" height="76">
                    </div>
                    <div class="text-white">
                        <div class="text-lg">Income</div>
                        <div class="text-2xl">
                            <?= $data['income'] ?> VND</div>
                    </div>
                </div>

                <div class="h-[160px] bg-red-500 rounded-xl shadow-lg p-6 flex items-center">
                    <div class="p-3 rounded-[50%] border-black border-2 bg-white m-5">
                        <img src="./public/icons/expense.svg" width="76" height="76">
                    </div>
                    <div class="text-white">
                        <div class="text-lg">Spending</div>
                        <div class="text-2xl"><?= $data['spending'] ?> VND</div>
                    </div>
                </div>

                <div class="h-[160px] bg-purple-400 rounded-xl shadow-lg p-6 flex items-center">
                    <div class="p-3 rounded-[50%] border-black border-2 bg-white m-5">
                        <img src="./public/icons/balance.svg" width="76" height="76">
                    </div>
                    <div class="text-white">
                        <div class="text-lg">Balance</div>
                        <div class="text-2xl"><?= $data['income'] - $data['spending'] ?> VND</div>
                    </div>
                </div>

            </div>

            <div class="my-5 w-full h0"></div>

            <!-- List -->
            <div>
                <div class="flex justify-between py-3">
                    <div class="text-2xl font-bold">Transactions List</div>
                    <button class="bg-green-600 px-6 py-2 rounded-md flex flex-row items-center hover:scale-105 transition-all">
                        <a class="flex" href="/expense-management-miniproject/create-expense">
                            <div class="pr-2">
                                <img src="./public/icons/add.svg" width="20" height="20">
                            </div>
                            <span>Create</span>
                        </a>
                    </button>
                </div>


                <div class="grid grid-cols-4 gap-4 justify-items-stretch">
                    <?php

                    require_once "app/enums/Category.php";

                    foreach ($data['expense'] as $item) {
                        $category =  $item['category'];
                        $description =  $item['description'];
                        $amount =  $item['amount'];
                        $image =  $item['image'];
                        $location =  $item['location'];
                        $id =  $item['id'];
                        $time = date('d/m/Y h:i:sa', strtotime($item['created_at']));

                        echo "<div onclick='redirectToExpense({$id})' class='border-black border rounded-lg py-3 px-5 
                                        duration-300
                                        hover:cursor-pointer
                                        hover:shadow-md
                                        hover:scale-105'>
            
                                    <div class='flex flex-row items-center'>
                                        <div class='rounded-[50%] border-black border-2 bg-white m-2'>
                                            <img src='$image' width='50' height='50'>
                                        </div>
            
                                        <div class='grid grid-cols-1 gap-2 mx-3 items-start'>
                                            <div class='bg-yellow-400 font-semibold py-1 px-5 rounded-full w-fit-content justify-self-start'>
                                                {$category}
                                            </div>
            
                                            <div class='flex flex-row justify-start'>
                                                <img src='./public/icons/comment-alt.svg' width='20' height='20' alt=''>
                                                <div class='mx-4'>{$description}</div>
                                            </div>
            
                                            <div class='flex flex-row justify-start'>
                                                <img src='./public/icons/time.svg' width='20' height='20' alt=''>
                                                <div class='mx-4 font-light italic'>{$time}</div>
                                            </div>
            
                                            <div class='flex flex-row justify-start'>
                                                <img src='./public/icons/location.svg' width='20' height='20' alt=''>
                                                <div class='mx-4 font-light'>{$location}</div>
                                            </div>
                                        </div>
                                    </div> 
                                ";
                        if ($amount < 0) {
                            echo "
                                <div class='float-right'>
                                        <span class='text-xl text-red-400'>$amount VND</span>
                                    </div>
                                </div>";
                        } else {
                            echo "
                            <div class='float-right'>
                                    <span class='text-xl text-green-400'>+$amount VND</span>
                                </div>
                            </div>";
                        }
                    }
                    ?>
                    <!-- <div class="border-black border rounded-lg py-3 px-5">
                        <div class="float-right">
                            <img src="./public/icons/menu-burger.svg" width="20" height="20">
                        </div>

                        <div class="flex flex-row items-center">
                            <div class="rounded-[50%] border-black border-2 bg-white m-2">
                                <img src="./public/icons/rent.svg" width="50" height="50">
                            </div>

                            <div class="grid grid-cols-1 gap-2 mx-3 items-start">
                                <div class="bg-green-300 py-1 px-2 rounded-full">
                                    Expense category
                                </div>

                                <div class="flex flex-row justify-start">
                                    <img src="./public/icons/comment-alt.svg" width="20" height="20" alt="">
                                    <div class="mx-4">Dong tien thue nha</div>
                                </div>

                                <div class="flex flex-row justify-start">
                                    <img src="./public/icons/time.svg" width="20" height="20" alt="">
                                    <div class="mx-4 font-light italic">15/08/2023 - 10:00am</div>
                                </div>

                                <div class="flex flex-row justify-start">
                                    <img src="./public/icons/location.svg" width="20" height="20" alt="">
                                    <div class="mx-4 font-light">Dai hoc Bach Khoa Ha Noi</div>
                                </div>
                            </div>
                        </div>

                        <div class="float-right">
                            <span class="text-xl text-red-400">-100.000VND</span>
                        </div>
                    </div> -->
                </div>
                <?php 
                    if (!count($data['expense'])) {
                        echo "<div class='min-h-[200px]'>
                            <div class='mx-auto flex flex-col items-center'>
                                <img src='public/icons/no-data.svg' width='184' height='152'>
                                <span class='text-md font-light text-gray-600'>No data</span>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </div>

</body>

<script>
    function redirectToExpense(id, url = '/expense-management-miniproject/expense/') {
        window.location.href = url + id;
    }
</script>

</html>