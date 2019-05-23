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
        <div class="row">
            <div class="col-md-12">
              <table class="table table-hover table-striped table-bordered">
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-user margin-r-5"></i></th>
                  <td>{{$userData->name}}</td>
                </tr>
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-phone margin-r-5"></i></th>
                  <td>{{$userData->phone}}</td>
                </tr>
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-envelope margin-r-5"></i></th>
                  <td>{{$userData->email}}</td>
                </tr>
                <tr>
                  <th class="text-center" scope="col"><i class="fa fa-file-text margin-r-5"></th>
                  <td>{{$userData->username}}</td>
                </tr>
  
              </table>
            </div>
            
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