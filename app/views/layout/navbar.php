<!-- Navbar -->
<div id="navbar" class="fixed top-0 left-0 right-0">
    <nav class="w-full h-[64px] bg-white shadow-lg flex items-center">
        <div class="flex flex-row justify-between w-full px-5">
            <!-- Logo -->
            <div class="flex flex-row justify-start items-center">
                <a href="/expense-management-miniproject/dashboard">
                    <img src="./public/icons/logo.svg" width="40" height="40">
                </a>
                <span class="font-semibold text-2xl px-5">Moneykeeper</span>
            </div>

            <!-- Right -->
            <div class="flex flex-row justify-end items-center">
                <img src="./public/icons/user.svg" width="40" height="40">
                <span class="px-4">
                    <?= $data['first_name'] ?>
                    <?= $data['last_name'] ?>
                </span>
                <!-- <img src="./public/icons/angle-down.svg" width="20" height="20"> -->
                <a href="/expense-management-miniproject/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-all">
                    Logout
                </a>
            </div>
        </div>
    </nav>
</div>