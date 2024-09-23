<?php
include "./config/utils.php";
$log = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (isset($username) && isset($email) && isset($password)) {
        if ($password === $confirmPassword) {
            handleRegister($username, $email, $password);
        }
    }
}

function handleRegister($username, $email, $password)
{
    global $log;
    $data  = array(
        'username' => $username,
        'email' => $email,
        'password' => $password
    );
    $url = 'http://localhost:1337/api/auth/local/register';
    $data =  handleCallAPI($url, "POST", json_encode($data));
    if (isset($data['jwt'])) {
        $log .= "Registration successful.";
    } else $log .= $data['error']['message'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div
        class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-[#fff] h-screen">
        <div class="text-center text-[24px] font-bold text-green"><?php echo $log   ?></div>
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">

            <h2
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Register
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="register.php" method="POST">
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            class="block text-[20px] px-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="username"
                            class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    </div>
                    <div class="mt-2">
                        <input
                            id="username"
                            name="username"
                            required
                            class="block text-[20px] px-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="block text-[20px] px-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                    </div>
                    <div class="mt-2">
                        <input
                            id="confirm_password"
                            name="confirm_password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="block text-[20px] px-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <a
                href="login.php"
                class="mt-10 text-center text-sm text-gray-500 block decoration-1">
                Log in
            </a>
        </div>
    </div>
</body>

</html>