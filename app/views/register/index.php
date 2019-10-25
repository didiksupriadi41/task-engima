<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register / Engima</title>
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo BASEURL; ?>css/custom.css"
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
                        id="form-register"
                        action="<?php echo BASEURL;?>register/insert"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <div class="card-body">
                            <div class="card-title text-center">
                                Welcome To <span>Engi</span>ma!
                            </div>
                            <div class="form-group" id="username-wrapper">
                                <label class="form-label">Username</label>
                                <input
                                    name="username"
                                    type="text"
                                    class="form-control"
                                    id="username-field"
                                    placeholder="johndoe"
                                >
                            </div>
                            <div class="form-group" id="email-wrapper">
                                <label class="form-label">Email Address</label>
                                <input
                                    name="email"
                                    type="email"
                                    class="form-control"
                                    id="email-field"
                                    placeholder="joe@email.com"
                                >
                            </div>
                            <div class="form-group" id="phone-wrapper">
                                <label class="form-label">Phone Number</label>
                                <input 
                                    name="phone"
                                    type="text"
                                    class="form-control"
                                    id="phone-field"
                                    placeholder="0813xxxxxxxx"
                                >
                            </div>
                            <div class="form-group" id="password-wrapper">
                                <label class="form-label">Password</label>
                                <input 
                                    name="password"
                                    type="password"
                                    class="form-control"
                                    id="password-field"
                                    placeholder="make as strong as possible"
                                >
                            </div>
                            <div class="form-group" id="confirmPassword-wrapper">
                                <label class="form-label">Confirm Password</label>
                                <input 
                                    name="confirmPassword"
                                    type="password"
                                    class="form-control"
                                    id="confirmPassword-field"
                                    placeholder="same as above"
                                >
                            </div>
                            <div class="form-group" id="file-wrapper">
                                <label class="form-label">Profile Picture</label>
                                <div class="row">
                                <div class="col-5">
                                    <input 
                                        name="filePath"
                                        type="text"
                                        class="form-control"
                                        id="filePath-field"
                                        disabled
                                    >                   
                                    <input 
                                        name="file"
                                        type="file"
                                        id="file-field"
                                        hidden
                                    >
                                </div>
                                <div class="col-5 btn-wrapper">
                                    <button 
                                        class="btn btn-gray btn-block" 
                                        id="btn-file"
                                    >
                                    Browse
                                    </button>
                                </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button
                                type="submit"
                                class="btn btn-primary btn-block"
                                id="btn-submit"
                                >
                                Register
                                </button>
                            </div>
                        </div>
                        <div class="text-center text-footer">
                            Already have an account?
                            <a href=<?php echo BASEURL."login"?>>
                                Login here
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <script src="<?php echo BASEURL;?>js/register.js"></script>
</body>
</html>