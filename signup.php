<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author"content="">

    <title>EMoneykeeper</title>

    <!-- Custom Font -->
    <!-- font-family: 'Lato', sans-serif; -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css'>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  </head>
  <body class="bg-[#E5E5E5] w-full">
    <!-- Navbar -->
    <div id="navbar" class="fixed top-0 left-0 right-0">
      <nav class="w-full h-[64px] bg-white shadow-lg flex items-center">
        <div class="flex flex-row justify-between w-full mx-5">
          <!-- Logo -->
          <div>
            <a href="./index.php">
            <img src="./public/icons/logo.svg" width="40" height="40">
            </a>
          </div>
          
          <!-- Right -->
          <div>Please log in</div>
        </div>
      </nav>
    </div>

    <div class="fixed top-[64px]">
      <!-- Sidebar -->
      <div id="sidebar" class="h-[1044px] w-20 bg-white flex-none">
        <div class="flex flex-col border-r-2 border-[#cdcdcd] items-center">
          <div>01</div>
          <div>01</div>
        </div>
      </div>
    </div>

    <div class="w-full top-[120px] left-[80px] relative">
      <div class="mx-auto bg-white rounded-xl w-[500px] border-2 border-[#f8f8f8] shadow-lg py-8 px-12">
        <div class="flex flex-col">
          <!-- Form -->
          <div class="text-3xl font-semibold text-center">Sign up</div>

          <div class ="pt-8">
            <form action="./includes/signup.inc.php" method="post">
              <!-- First Name -->
              <div class="flex flex-col py-3">
                <span class="text-sm">First name</span>
                <input 
                  type="text" 
                  name="firstname" 
                  placeholder="Type your first name"
                  class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]"
                >
              </div>

              <!-- Last Name -->
              <div class="flex flex-col py-3">
                <span class="text-sm">Last name</span>
                <input 
                  type="text" 
                  name="lastname" 
                  placeholder="Type your last name"
                  class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]"
                >
              </div>

              <!-- Email -->
              <div class="flex flex-col py-3">
                <span class="text-sm">Email</span>
                <input 
                  type="text" 
                  name="email" 
                  placeholder="Type your email"
                  class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]"
                >
              </div>

              <!-- Password -->
              <div class="flex flex-col py-3">
                <span class="text-sm">Password</span>
                <input 
                  type="password" 
                  name="password" 
                  placeholder="Type your password"
                  class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]"
                >
              </div>

              <!-- Confirm password -->
              <div class="flex flex-col py-3">
                <span class="text-sm">Confirm password</span>
                <input 
                  type="password" 
                  name="confirmpassword" 
                  placeholder="Confirm password"
                  class="h-[55px] w-full px-6 border-b-2 border-[#cdcdcd]"
                >
              </div>

              <!-- Login -->
              <div class="flex-none pb-8">
                <div class="mx-auto text-right text-sm">
                  <a href="./login.php" >Already have account ?</a>
                </div>
              </div>

              <!-- Submit button -->
              <div class="flex-none px-10">
                <button type="submit" class="w-full">
                  <div class="bg-blue-500 text-xl text-white text-center mx-auto py-4 rounded-[25px] shadow-lg hover:bg-blue-700">
                    SIGN UP
                  </div>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>