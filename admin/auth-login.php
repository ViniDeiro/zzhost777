<?php include 'partials/html.php' ?>


<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include_once 'services/database.php';
include_once 'services/funcao.php';
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once "services/CSRF_Protect.php";
$csrf = new CSRF_Protect();
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <?php $title = "expfygaming"; include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php'; ?>
    <?php include 'partials/vendorjs.php'; ?>
    <script src="../../yq-br-prod/web1/assets/ActionBlockGame-Nhsadas_32_32.js"></script>
</head>

<style>
    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -1;
        top: 0;
        left: 0;
        opacity: 0.2;
    }

    #response {
        display: none;
    }
    
    input[type="email"],
    input[type="password"] {
        font-size: 16px;
    }
    
    input[type="email"],
    input[type="text"] {
        font-size: 16px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div id="particles-js"></div>
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                        <div id="response"></div>
                        <br>
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="index.php" class="logo logo-admin">
                                            <img src="../uploads/<?= $dataconfig['logo'] ?>" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        </h4>
                                        <p class="text-muted fw-medium mb-0">Faça login para continuar.</p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" id="form-acessar" class="my-4">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Digite seu E-mail">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">Senha</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua Senha">
                                                <span class="input-group-text" onclick="togglePassword('senha', this)">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        
                                <!--        <div class="form-group">
                                            <label class="form-label mt-2" for="usertoken">Token</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="token" id="token" placeholder="Digite seu Token">
                                                <span class="input-group-text" onclick="togglePassword('token', this)">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </div>
                                        </div> -->

                                    <!--    <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="customSwitchSuccess">
                                                    <label class="form-check-label" for="customSwitchSuccess">Manter
                                                        Conectado</label>
                                                </div>
                                            </div> 

                                        </div> -->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <?php $csrf->echoInputField(); ?>
                                                    <button class="btn btn-primary" type="submit">Acessar <i
                                                            class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        const iconElement = icon.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
        }
    }

    $(document).ready(function () {
        $('#form-acessar').submit(function (event) {
            event.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: 'ajax/form-acessar.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#response').html(response).show();
                    setTimeout(function () {
                        $('#response').hide();
                    }, 9000);
                },
            });
        });
    });
</script>

</html>