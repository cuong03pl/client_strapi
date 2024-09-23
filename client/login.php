<?php
session_start();
include "./config/common.php";
include "./config/utils.php";
if (isset($_SESSION["jwt"])) {
    header("Location: index.php");
}
if (isset($_COOKIE['remember_me'])) {
    getUserByToken($_COOKIE['remember_me']);
}
$log = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($username) && isset($password)) {
        handleLogin($username, $password);
    }
}

function getUserByToken($token)
{
    $url = 'http://localhost:1337/api/users?filters[token][$eq]=' . $token;

    $data = handleCallAPI($url, 'GET', "");
    if ($data) {
        $_SESSION['jwt'] = $data[0]['token'];
        $_SESSION["username"] = $data[0]['username'];
        header("Location: index.php");
    }
}

// save token to database by Strapi API
function saveToken($id, $token)
{
    $data = json_encode([
        'token' => $token
    ]);
    $url = 'http://localhost:1337/api/users/' . $id . '';

    handleCallAPI($url, 'PUT', $data);
}
function handleLogin($username, $password)
{
    global $log;
    if (!isset($_POST['g-recaptcha-response'])) {
        return;
    }
    $recaptcha_secret = SECRET_KEY_CAPTCHA;
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success']) {
        $log .= "CAPTCHA verification failed. Please try again.";
        return;
    }

    $data  = array(
        'identifier' => $username,
        'password' => $password
    );
    $url = "http://localhost:1337/api/auth/local";

    $data = handleCallAPI($url, 'POST', json_encode($data));
    if (isset($data['jwt'])) {
        $_SESSION["jwt"] = $data['jwt'];
        $_SESSION["username"] = $username;
        $id = $data['user']["id"];
        if (isset($_POST['remember_me'])) {
            saveToken($id, $data['jwt']);
            setcookie('remember_me', $data['jwt'], time() + (86400 * 30), "/");
        }
        header("Location: index.php");
    } else $log .= "Login fail";
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div
        class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-[#fff] h-screen">
        <div class="text-center text-[24px] font-bold text-green"><?php echo $log  ?></div>
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">

            <h2
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Sign in to your account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label
                        for="username"
                        class="block text-sm font-medium leading-6 text-gray-900">Username / Email</label>
                    <div class="mt-2">
                        <input
                            id="username"
                            name="username"
                            type="text"
                            autocomplete="username"
                            required
                            class="block text-[20px] px-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="text-sm">
                            <a
                                href="forget_password.php"
                                class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
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
                    <div class="mt-2 flex items-center gap-3">
                        <input style="width: 20px; height: 20px;" class="form-check-input" name="remember_me"
                            type="checkbox" checked id="flexCheckDefault">
                        <label class="" for="flexCheckDefault">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="g-recaptcha" data-sitekey='<?php echo SITE_KEY_CAPTCHA ?>'></div>
                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <a
                href="register.php"
                class="mt-10 text-center text-sm text-gray-500 block decoration-1">
                Register
            </a>
        </div>
    </div>
</body>

</html>