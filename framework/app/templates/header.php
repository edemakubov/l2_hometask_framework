<?php
//get container
use Src\Container\Container;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

$container = Container::getInstance();
$session = $container->get(SessionInterface::class);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Framework</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>

            <?php if (!($session->get('user_id'))) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/loginform">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/registerform">Register</a>
                </li>
            <?php } else { ?>

                <li class="nav-item active">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/logout">Exit</a>
                </li>
            <?php } ?>
        </ul>

    </div>
</nav>
<div class="container p-5">
