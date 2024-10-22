<?php

session_start();


?>


<header class="h-16 bg-white/70 backdrop-blur px-4 py-2 flex justify-between sticky top-0 z-10 border-b border-blue-500">
    <a href="index.php" class="text-blue-500 font-bold text-3xl flex gap-4 "><img class="h-10" src="/public/logo.png"
                                                                                  alt="RentaCar logo">Renta Car</a>
    <div class="flex gap-2 items-center">

        <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
            <a href="rented.php"
               class="bg-indigo-400 px-2 py-1 rounded-lg flex items-center justify-center text-white font-semibold border-indigo-400 border-2 hover:bg-white hover:text-indigo-400">[
                Rented cars list]</a>
            <a href="users.php"
               class="bg-indigo-400 px-2 py-1 rounded-lg flex items-center justify-center text-white font-semibold border-indigo-400 border-2 hover:bg-white hover:text-indigo-400">[
                Users list]</a>
            <a href="create.php"
               class="bg-indigo-400 px-2 py-1 rounded-lg flex items-center justify-center text-white font-semibold border-indigo-400 border-2 hover:bg-white hover:text-indigo-400">[+
                Add car]</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['email']) && isset($_SESSION['fullName'])): ?>
            <div class="flex gap-2 items-center mx-8">
                <div class="text-sm text-slate-500">
                    <p>
                        <i class="fa fa-user"></i>
                        <a href="profile.php?id=<?= $_SESSION['userId'] ?>"><?= $_SESSION['fullName'] ?></a>

                    </p>
                    <p>
                        <i class="fa fa-envelope"></i>
                        <?= $_SESSION['email'] ?>
                    </p>


                </div>
                <div>
                    <a href="logout.php" class="px-2 py-1 border-2 border-slate-500 text-slate-500 rounded">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <a href="auth.php"
               class="bg-amber-500 px-2 py-1 rounded-lg flex items-center justify-center text-white font-semibold border-amber-500 border-2 hover:bg-white hover:text-amber-500">
                Sign in</a>
        <?php endif ?>


    </div>

</header>
