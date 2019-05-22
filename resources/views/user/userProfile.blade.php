@section('title')
Perfil de Usuario
@stop
@section('morecss')
<link rel="stylesheet" href="{{ asset('assets/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@stop
@extends('base')
@section('content')
<section class="content-header">
  <h1>
    Meu Perfil
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('/') }}"></i>Início</a></li>
    <li class="active"><a href="/perfil">Perfil de Usuário</a></li>
  </ol>
</section>
<section class="content">
  <div class="box box-default">
    <div class="box-body">
      <strong><i class="fa fa-user margin-r-5"></i> Nome Completo</strong>

      <p class="text-muted">
        {{$userData->name}}
      </p>

      <hr>

      <strong><i class="fa fa-phone margin-r-5"></i> Telefone</strong>

      <p class="text-muted">{{$userData->phone}}</p>

      <hr>

      <strong><i class="fa fa-envelope margin-r-5"></i> E-mail</strong>

      <p class="text-muted">{{$userData->email}}</p>

      <hr>

      <strong><i class="fa fa-file-text margin-r-5"></i> Cpf</strong>

      <p class="text-muted">{{$userData->username}}</p>
    </div>
    <div class="box-footer">
      <p class="font-weight-bold">Dados de usuário são importados da MinhaUFOP, para alteração acesse o <a
          href="https://zeppelin10.ufop.br/minhaUfop/desktop/login.xhtml">link</a></p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>

@stop