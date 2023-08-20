<?php

require_once "app/enums/Category.php";

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

  <script src="/expense-management-miniproject/public/js/create.js"></script>

</head>

<body class="bg-[#E5E5E5] w-full">
  <?php include 'app/views/layout/navbar.php' ?>

  <!-- Main container -->
  <form action="/expense-management-miniproject/create-expense" method="post" onsubmit="" enctype="multipart/form-data">
    <div class="px-9 pt-6 pb-16 bg-white h-screen flex flex-col">
      <!-- <div class="float-left mt-16 bg-[#f9f9f9] rounded-full px-5 py-3 flex-none self-start">
        <a class="flex mx-auto">
          <img src="public/icons/back.svg" width="20" height="20">
          <span class="mx-5">Back</span>
        </a>
      </div> -->

      <div class="flex flex-row self-center items-center flex-1 justify-stretch">
        <div class="p-12 bg-white m-5">
          <!-- <button class="float-right">
              <div class="bg-gray-300 px-5 py-2 hover:bg-gray-400">
                Add Image
              </div>
            </button> -->
          <input type="file" name="imageFile" id="imageFile">
          <img src="public/icons/rent.svg" width="240" height="240">
        </div>
        <div class="grid grid-cols-1 gap-6 text-xl ml-16 justify-item-stretch">

          <div class="flex flex-row justify-start rounded-full border-2 border-[#cdcdcd] px-4 py-2 bg-gray-100">
            <img src="public/icons/comment-alt.svg" width="30" height="30" alt="">
            <input type="text" name="description" placeholder="Description" class="bg-gray-100 mx-2">
          </div>

          <div class="flex flex-row justify-start rounded-full border-2 border-[#cdcdcd] px-4 py-2 bg-gray-100">
            <img src="public/icons/location.svg" width="30" height="30" alt="">
            <input type="text" name="location" placeholder="Location" class="bg-gray-100 mx-2">
          </div>

          <div class="flex flex-row justify-start rounded-full border-2 border-[#cdcdcd] px-4 py-2 bg-gray-100">
            <img src="public/icons/usd-circle.svg" width="30" height="30" alt="">
            <input type="text" name="amount" placeholder="Amount" class="bg-gray-100 mx-2">
          </div>

          <div class="flex flex-row justify-start rounded-full border-2 border-[#cdcdcd] px-4 py-2 bg-gray-100">
            <select name="category" class="w-full">
              <option value="" selected hidden>Category</option>
              <?php
              foreach (Category::CATEGORY as $key => $value) {
                echo "<option value='$value'>$key</option>";
              }
              ?>
            </select>
          </div>

        </div>
      </div>

      <div class="self-end grid grid-cols-3 gap-8 flex-initial pr-5 font-bold">
        <button class="drop-shadow-xl" type="submit" name="createForm">
          <div class="bg-green-600 rounded-md px-4 py-3 text-white flex hover:bg-green-700">
            <img src="public/icons/add.svg" width="20" height="20">
            <span class="mx-5">Create</span>
          </div>
        </button>

        <button class="drop-shadow-lg">
          <a href="/expense-management-miniproject/dashboard" class="bg-[#f9f9f9] rounded-md px-4 py-3 flex hover:bg-gray-300">
            <img src="public/icons/back.svg" width="20" height="20">
            <span class="mx-auto">Cancel</span>
          </a>
        </button>
      </div>

    </div>
  </form>

  <?php

  if (isset($data['errors'])) {
    echo '<script>
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "' . strval($data['errors'][0]) . '"
        });
      </script>';
  }

  ?>
</body>

</html>