<?php
date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $data['title'] ?></title>
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo BASEURL; ?>css/custom.css"
    >
    <link 
href="https://fonts.googleapis.com/css?family=Raleway:400,700,800,900&display=swap" 
        rel="stylesheet"
    >
</head>

<body>
    <div class="page">
        <div class="page-main">
            <div class="header py-4">
                <div class="container">
                    <div class="d-flex">
                        <a class="header-brand" href="<?php echo BASEURL; ?>">
                            <div class="logo-brand">
                                Engi<span>ma</span>
                            </div>
                        </a>
                        <form 
                            class="input-icon my-3 my-lg-0" 
                            method="GET" 
                            action="<?php echo BASEURL."movie/search";?>"
                        >
                            <input 
                                type="search" 
                                class="form-control header-search" 
                                placeholder="Search movie"
                                name="q"
                            >
                            <div class="input-icon-addon">
                                <button class="search-btn">
                                    &#x1F50D
                                </button>
                            </div>
                        </form>
                        <div class="d-flex order-lg-2 ml-auto">
                            <div class="nav-item d-none d-md-flex">
                                <a href="<?php echo BASEURL."transaction" ?>">
                                    Transaction
                                </a>
                            </div>
                            <div class="nav-item d-none d-md-flex">
                                <a href="<?php echo BASEURL."logout" ?>">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
