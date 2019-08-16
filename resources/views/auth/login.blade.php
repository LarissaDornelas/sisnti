<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <title>SisNti | Login</title>

    <link media="all" type="text/css" rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="assets/css/adminLTE/AdminLTE.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="assets/css/font-awesome/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
        <body class="hold-transition login-page skin-ufop guest">
                <div class="login-box">
                    <div class="login-logo">
                        <i><img src="assets/img/icone-login.png"></i> <b>Si</b>stema de <b>Su</b>porte
                    </div>
                    <!-- /.login-logo -->
                    <div class="login-box-body ufop-border">
                        <p class="login-box-msg">Faça o login para solicitar abertura de chamado </p>
                
                        <div class="form">
                            <form method="POST" action="{{ route('login') }}" method="post">
                                {{ csrf_field()}}
                                <div class="input-group  @if($errors->has('credentials') || $errors->has('server')) has-error @endif"> 
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="username" data-mask="000.000.000-00" minlength="11" maxlenght="11" data-mask-reverse="true" class="form-control" placeholder="CPF da Minha Ufop" required="true" data-toggle="tooltip" data-placement="right" autofocus="true" title="CPF da Minha Ufop" type="text">
                                </div>
                
                                <div class="input-group  @if($errors->has('credentials') || $errors->has('server')) has-error @endif ">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Senha do Minha UFOP" required data-toggle="tooltip" data-placement="right" title="Senha do Minha UFOP">
                                </div>
                
                                <br />
                
                                <div class="text-center">
                                    <input id="remember-me" type="checkbox" name="remember-me" />
                                    <label for="remember-me">Lembre-se de mim</label>
                                </div>
                                   
                                @if($errors->has('credentials') || $errors->has('server'))
                                 @foreach($errors->all() as $error)
                                    <h5 class="text-center text-danger"><b><i class="fa fa-exclamation-circle"></i> Erro <br/> {!! $error !!}</b></h5>
                                  @endforeach
                                @endif 
                                                    
                                <br/>
                                <button  style ="background-color: #962038" class="btn btn-primary center-block btn-block">
                                <input style="margin:0;padding:0;height:0;width:0;visibility:collapse" type="submit" value="">
                                <i class="fa fa-sign-in"></i> Entrar
                                </button>
                            </form>
                        </div>
                        <hr />
                        <p class="text-center">Use o <span class="text-bold">mesmo CPF</span> e a <span class="text-bold">mesma senha</span><br /> do <a href="http://www.minha.ufop.br/" target="_blank"><i class="fa fa-home"></i>Minha UFOP</a></p>
                    </div>
                </div>
                
                <br />
                
                <footer class="text-center">
                    <!-- Default to the left -->
                    <strong>Copyleft <i class="fa fa-creative-commons"></i>  DATA<a href="">NTI ICEA</a></strong>


                
                <script src="assets/js/jQuery/jquery-2.2.4.min.js"></script>   
                <script src="assets/js/adminLTE/app.min.js"></script>  
                <script src="assets/js/jQueryMask/jquery.mask.min.js"></script>

               
            </body>
</html>