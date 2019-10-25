<?php
    $flash = new \core\Flash;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login / Engima</title>
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo BASEURL; ?>/css/custom.css"
    >
    <link 
        href="https://fonts.googleapis.com/css?family=Raleway&display=swap" 
        rel="stylesheet"
    >
</head>

<body>
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="login mx-auto">
                    <form 
                        class="card" 
                        action="<?php echo BASEURL;?>login" 
                        method="POST"
                    >
                        <div class="card-body">
                            <div class="card-title text-center">
                                Welcome To <span>Engi</span>ma!
                            </div>
             
                            <?php
                            if ($danger = $flash->danger()) {
                                ?>
                                <div class="alert alert-danger">
                                    <?php echo $danger; ?>
                                    <span 
                                        class="closebtn" 
                                        onclick="this.parentElement.style.display=
                                            'none';"
                                    >
                                    &times;
                                </div>
                                <?php
                            }
                            ?>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input 
                                    name="email"
                                    type="email" 
                                    class="form-control" 
                                    placeholder="john@doe.com"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    Password
                                </label>
                                <input 
                                    name="password" 
                                    type="password" 
                                    class="form-control" 
                                    placeholder="place here"
                                >
                            </div>
                            <div class="form-footer">
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-block"
                                >
                                    Login
                                </button>
                            </div>
                        </div>
                        <div class="text-center text-footer">
                            Don't have an account? 
                            <a href=<?php echo BASEURL. "register"?>
                                >Register here
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>