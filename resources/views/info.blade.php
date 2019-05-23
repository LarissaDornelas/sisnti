@section('title')
Sobre
@stop
@section('morecss')
<link rel="stylesheet" href="{{ asset('assets/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@stop
@extends('base')
@section('content')
<section class="content-header">
  <h1>
    Informações do Sistema
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('/') }}"></i>Início</a></li>
    <li class="active"><a href="/info">Sobre</a></li>
  </ol>
</section>
<section class="content">
  <div class="box box-default">
    <div class="box-body">
        <div class="row">
        <div class="col-md-12">
          <table class="table table-hover table-striped table-bordered">
            <tr>
              <th scope="col"><i class="fa fa-bullseye margin-r-5"></i> Objetivo </th>
            </tr>
            <tr>  
              <td>Auxiliar o setor de informática a gerencias as solicitações de serviço.</td>
            </tr>
            <tr>
              <th scope="col"><i class="fa fa-users margin-r-5"></i>Usuários</th>
            </tr>
            <tr>  
              <td>Os usuários do sistema são providos da MinhaUfop, ou seja, 
                  quem for acessar o sistema deve utilizar o mesmo usuário e 
                  senha que utiliza no sistema da MinhaUfop, sendo o CPF como 
                  login e a senha cadastrada.</td>
            </tr>
            <tr>
              <th scope="col"><i class="fa fa-book margin-r-5"></i>Como funciona</th>
            </tr>
            <tr>  
              <td> Basta acessar o sistema e assim o usuário terá acesso a 
                  interface que irá disponibilizar um formulário para abertura 
                  de chamados de serviços ao NTI, também será disponibilizado 
                  interfaces para acompanhamento dos chamados abertos pelo usuário, 
                  contando com detalhes de quem é o responsável pelo chamado, 
                  qual a previsáo de atendimento, entre outras informações.</td>
            </tr>
          </table>
        </div>
        
      </div>
    </div>

    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>

@stop