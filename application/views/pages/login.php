<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="~/Content/bootstrap.min.css" rel="stylesheet" />
    <link href="~/Content/font-awesome.min.css" rel="stylesheet" />
    <link href="~/Content/ionicons.min.css" rel="stylesheet" />
    <link href="~/admin-lte/css/AdminLTE.min.css" rel="stylesheet" />
    <link href="~/admin-lte/css/AdminLTE.min.css" rel="stylesheet" />
    <link href="~/admin-lte/css/skins/_all-skins.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <style>
        .limiter {
            width: 100%;
            margin: 0 auto;
        }

        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: #9053c7;
            background: -webkit-linear-gradient(-135deg, #d6d6d6, #d6d6d6);
            background: -o-linear-gradient(-135deg, #d6d6d6, #d6d6d6);
            background: -moz-linear-gradient(-135deg, #d6d6d6, #d6d6d6);
            background: linear-gradient(-135deg, #d6d6d6, #d6d6d6);
        }

        .wrap-login100 {
            width: 100%;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 80px 16px 33px 0px;
        }

        .login100-pic {
            width: 316px;
        }

        .login100-form-title {
            font-family: Poppins-Bold;
            font-size: 24px;
            color: #333333;
            line-height: 1.2;
            text-align: center;
            width: 100%;
            display: block;
            padding-bottom: 54px;
        }

        .wrap-input100 {
            position: relative;
            width: 100%;
            z-index: 1;
            margin-bottom: 10px;
        }

        .login100-form {
            width: 290px;
        }

        .login100-form-title {
            font-family: Poppins-Bold;
            font-size: 24px;
            color: #333333;
            line-height: 1.2;
            text-align: center;
            width: 100%;
            display: block;
            padding-bottom: 54px;
        }

        .validate-input {
            position: relative;
        }

        .input100 {
            font-family: Poppins-Medium;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
            display: block;
            width: 100%;
            background: #e6e6e6;
            height: 50px;
            border-radius: 25px;
            padding: 0 30px 0 68px;
        }

        .focus-input100 {
            display: block;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            box-shadow: 0px 0px 0px 0px;
            color: rgba(87,184,70, 0.8);
        }

        .focus-input100 {
            display: block;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            box-shadow: 0px 0px 0px 0px;
            color: rgba(87,184,70, 0.8);
        }

        .symbol-input100 {
            font-size: 15px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding-left: 35px;
            pointer-events: none;
            color: #666666;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .login100-form-btn {
            font-family: Montserrat-Bold;
            font-size: 15px;
            line-height: 1.5;
            color: #fff;
            text-transform: uppercase;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            background: #ff4949;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 25px;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .p-t-12 {
            padding-top: 12px;
        }

        .txt1 {
            font-family: Poppins-Regular;
            font-size: 13px;
            line-height: 1.5;
            color: red;
        }

        .txt2 {
            font-family: Poppins-Regular;
            font-size: 13px;
            line-height: 1.5;
            color: #666666;
        }

        .p-t-136 {
            padding-top: 136px;
        }
    </style>
</head>
<body class="hold-transition login-page" style="background-color:white;">




    <div class="limiter">
        <div class="container-login100">
            <div class="row">
                <div class="col-md-12">
                    <div class="wrap-login100">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" style="padding-right:0px !important;">
                            <div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
                                <img src="~/Content/images/rpd.jpg" alt="IMG" style="margin-top:23% !important;width:100% !important;"/>
                            </div>
                            
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <form class="login100-form validate-form form-login" method="post">
                                <span class="login100-form-title">
                                    ECAPS
                                </span>

                                <div class="wrap-input100 validate-input">
                                    <input class="input100" type="text" placeholder="Username" name="username" id="username" style="border:0px !important;">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input" data-validate="Password is required">
                                    <input class="input100" type="password" name="password" id="password" placeholder="Password" style="border:0px !important;">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="container-login100-form-btn">
                                    <!-- <button class="login100-form-btn">Login</button> -->
                                    <input class="login100-form-btn" type="submit" name="submit" id="submit" value="Login" style="border:0px !important;">
                                </div>

                                <!--<div class="text-center p-t-12">
                                    <span class="txt1">
                                        Forgot
                                    </span>
                                    <a class="txt2" href="#">
                                        Username / Password?
                                    </a>
                                </div>-->

                                <div class="text-left p-t-136" style="margin-left: 0px">
                                    <a class="txt2" href="#">
                                        Powered by
                                    </a><a href="http://reputabletechnologies.com" target="_blank">REPUTABLETECHNOLOGIES PVT.LTD.</a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="~/Scripts/jquery-3.4.1.min.js"></script>
    <script src="~/Scripts/bootstrap.min.js"></script>
    <script src="~/admin-lte/js/adminlte.min.js"></script>
    <script src="~/admin-lte/js/demo.js"></script>


</body>
</html>