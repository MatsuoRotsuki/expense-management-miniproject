<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Genuine PHP Project</title>

  <!-- Custom Font -->
  <!-- font-family: 'Lato', sans-serif; -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="public/icons/logo.svg">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#E5E5E5] w-full">
  <div class="w-full top-[80px] relative">
    <div class="mx-auto bg-white rounded-xl w-[500px] border-2 border-[#f8f8f8] shadow-lg py-8 px-12">
      <div class="flex flex-col">
        <!-- Form -->
        <div class="text-3xl font-semibold text-center">Sign up</div>

        <div class="pt-8">
          <form action="/expense-management-miniproject/signup" method="post" onsubmit="return checkOnSubmit()">
            <!-- First Name -->
            <div class="flex flex-col py-3">
              <span class="text-sm">First name</span>
              <input type="text" name="firstname" placeholder="Type your first name" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="firstname_error" class="ml-6 text-sm text-red-600 invisible">First-name must be longer than 1 characters</span>
            </div>

            <!-- Last Name -->
            <div class="flex flex-col py-3">
              <span class="text-sm">Last name</span>
              <input type="text" name="lastname" placeholder="Type your last name" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="lastname_error" class="ml-6 text-sm text-red-600 invisible">Last-name must be longer than 1 characters</span>
            </div>

            <!-- Email -->
            <div class="flex flex-col py-3">
              <span class="text-sm">Email</span>
              <input type="text" name="email" placeholder="Type your email" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="email_error" class="ml-6 text-sm text-red-600 invisible">Email format is not correct</span>
            </div>

            <!-- Password -->
            <div class="flex flex-col py-3">
              <span class="text-sm">Password</span>
              <input type="password" name="password" placeholder="Type your password" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="password_error" class="ml-6 text-sm text-red-600 invisible">Password must be longer than 6 characters</span>
            </div>

            <!-- Confirm password -->
            <div class="flex flex-col py-3">
              <span class="text-sm">Confirm password</span>
              <input type="password" name="confirmpassword" placeholder="Confirm password" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="confirmpassword_error" class="ml-6 text-sm text-red-600 invisible">Password must be longer than 6 characters</span>
            </div>

            <!-- Login -->
            <div class="flex-none pb-8">
              <div class="mx-auto text-right text-sm">
                <a href="./login">Already have account ?</a>
              </div>
            </div>

            <!-- Submit button -->
            <div class="flex-none px-10">
              <input id="signupSubmit" name="signupSubmit" value="SIGN UP" type="submit" class="cursor-pointer w-full bg-blue-500 text-xl text-white text-center mx-auto py-4 rounded-[25px] shadow-lg hover:bg-blue-700">
              </input>
              </input>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($data['errorMessage'])) {
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "' . strval($data['errorMessage']) . '"
        });
      </script>';
  }
  ?>

</body>
<script src="/expense-management-miniproject/public/js/signup.js"></script>
<link rel="stylesheet" href="/expense-management-miniproject/public/css/login.css">

</html>