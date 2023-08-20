<?php


?>
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

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#E5E5E5] w-full">
    <?php include 'app/views/layout/navbar.php' ?>

    <!-- Main container -->
    <div class="px-9 pt-6 pb-16 bg-white h-screen flex flex-col">
        <!-- <div class="float-left mt-16 bg-[#f9f9f9] rounded-full px-5 py-3 flex-none self-start">
            <button class="flex mx-auto">
                <img src="../public/icons/back.svg" width="20" height="20">
                <span class="mx-5">Back</span>
            </button>
        </div> -->

        <div class="flex flex-row self-center items-center flex-1 justify-stretch">
            <div class="p-12 rounded-full border-black border-2 bg-white m-5">
                <img src="<?= '.' . $data['image'] ?>" width="240" height="240">
            </div>
            <div class="grid grid-cols-1 gap-6 text-xl ml-16 justify-items-start">
                <div class="px-5 py-2 bg-green-600 text-white rounded-md">
                    <?= $data['category'] ?>
                </div>

                <div class="flex flex-row justify-start">
                    <img src="../public/icons/comment-alt.svg" width="30" height="30" alt="">
                    <div class="mx-4">
                        <?= $data['description'] ?>
                    </div>
                </div>

                <div class="flex flex-row justify-start">
                    <img src="../public/icons/time.svg" width="30" height="30" alt="">
                    <div class="mx-4 italic">
                        <?= $data['created_at'] ?>
                    </div>
                </div>

                <div class="flex flex-row justify-start">
                    <img src="../public/icons/location.svg" width="30" height="30" alt="">
                    <div class="mx-4">
                        <?= $data['location'] ?>
                    </div>
                </div>

                <div class="flex flex-row justify-start">
                    <img src="../public/icons/usd-circle.svg" width="30" height="30" alt="">
                    <div class="mx-4 text-red-500">
                        <?= $data['amount'] ?> VND
                    </div>
                </div>
            </div>
        </div>

        <div class="self-end grid grid-cols-3 gap-8 flex-initial pr-5 font-bold">
            <?php
            echo "<button id='deleteBtn' class='drop-shadow-xl' data-src='/expense-management-miniproject/delete-expense/{$data['id']}'>
                    <div class='bg-red-500 rounded-md px-4 py-3 text-white flex transition-all hover:scale-105'>
                        <img src='../public/icons/delete.svg' width='20' height='20'>
                        <span class='mx-5'>Delete</span>
                    </div>
                </button>

                <button class='drop-shadow-xl'>
                    <a href='/expense-management-miniproject/update-expense/{$data['id']}' class='bg-purple-500 rounded-md px-4 py-3 text-white flex transition-all hover:scale-105'>
                        <img src='../public/icons/edit.svg' width='20' height='20'>
                        <span class='mx-auto'>Edit</span>
                    </a>
                </button>";
            ?>

            <button class="drop-shadow-lg transition-all hover:scale-105">
                <a href="/expense-management-miniproject/dashboard" class="bg-[#f9f9f9] rounded-md px-4 py-3 flex">
                    <img src="../public/icons/back.svg" width="20" height="20">
                    <span class="mx-auto">Cancel</span>
                </a>
            </button>
        </div>

    </div>

</body>

<script>
    const deleteBtn = document.getElementById('deleteBtn');
    deleteBtn.addEventListener('click', async () => {
        const confirmed = await Swal.fire({
            title: 'Confirm Delete',
            text: 'Are you sure you want to delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        });

        if (confirmed.isConfirmed) {
            try {
                const response = await fetch(deleteBtn.getAttribute('data-src'));
                window.location.href = '/expense-management-miniproject/dashboard';
            } catch (error) {
                console.error(error);
            }
        }
    });
</script>

</html>