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
  <!-- Navbar -->
  <!-- <div id="navbar" class="fixed top-0 left-0 right-0">
    <nav class="w-full h-[64px] bg-white shadow-lg flex items-center">
      <div class="flex flex-row justify-between w-full mx-5">
        <div>
          <a href="./index.php">
            <img src="./public/icons/logo.svg" width="40" height="40">
          </a>
        </div>

        <div>Please login</div>
      </div>
    </nav>
  </div> -->

  <!-- <div class="fixed top-[64px]">
    <div id="sidebar" class="h-[1044px] w-20 bg-white flex-none">
      <div class="flex flex-col border-r-2 border-[#cdcdcd] items-center">
        <div>01</div>
        <div>01</div>
      </div>
    </div>
  </div> -->

  <div class="w-full top-[120px] relative">
    <div class="mx-auto bg-white rounded-xl w-[500px] border-2 border-[#f8f8f8] shadow-lg py-8 px-12">
      <div class="flex flex-col">
        <!-- Form -->
        <div class="text-3xl font-semibold text-center">Log in</div>

        <div class="pt-8">
          <form action="/expense-management-miniproject/login" method="post" onsubmit="return checkOnSubmit()">
            <!-- Email -->
            <div class="flex flex-col py-3">
              <span class="text-sm">Email</span>
              <input id="email" type="text" name="email" placeholder="Type your email" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="email_error" class="ml-6 text-sm text-red-600 invisible">Email format is not correct</span>
            </div>

            <!-- Password -->
            <div class="flex flex-col py-3">
              <span class="text-sm">Password</span>
              <input id="password" type="password" name="password" placeholder="Type your password" class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]">
              <span id="password_error" class="ml-6 text-sm text-red-600 invisible">Password must be longer than 6 characters</span>
            </div>

            <!-- Remember me? -->
            <div class="flex items-center gap-2">
              <label for="remember_me">Remember me:</label>
              <input type="checkbox" id="remember_me" name="rememberMe">
            </div>

            <!-- Forgot Password? -->
            <div class="flex-none pb-8">
              <div class="mx-auto text-right text-sm">
                <a href="/expense-management-miniproject/signup">Do not have an account ?</a>
              </div>
            </div>

            <!-- Submit button -->
            <div class="flex-none px-10">
              <input id="loginSubmit" name="loginSubmit" value="LOGIN" type="submit" class="cursor-pointer w-full bg-blue-500 text-xl text-white text-center mx-auto py-4 rounded-[25px] shadow-lg hover:bg-blue-700">
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


<script src="/expense-management-miniproject/public/js/login.js"></script>
<link rel="stylesheet" href="/expense-management-miniproject/public/css/login.css">

</html>