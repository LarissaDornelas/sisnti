@section('title')
Novo Chamado
@stop
@extends('base')
@yield('isAdmin')
@section('content')
<section class="content-header">
  <h1>
    Novo Chamado
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('/') }}"></i>Início</a></li>
    <li><a href="/solicitacao">Meus Chamados</a></li>
    <li class="active">Novo</li>
  </ol>
</section>

<section class="content">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Solicitante</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label>Nome</label>
            <input name="name" type="text" class="form-control" disabled="disabled" value="{{ Auth::user()->name }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Telefone</label>
            <input name="phone" data-mask="(00)000000000" type="text" class="form-control" disabled="disabled"
              value="{{ Auth::user()->phone }}">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Email</label>
            <input name="email" type="text" class="form-control" disabled="disabled" value="{{ Auth::user()->email }}">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <p class="font-weight-bold">Dados de usuário são importados da MinhaUFOP, para alteração acesse o <a
            href="https://zeppelin10.ufop.br/minhaUfop/desktop/login.xhtml">link</a></p>
      </div>
    </div>
  </div>
  <form method="POST" action="{{ route('openTask') }}" method="post">
    {{ csrf_field()}}
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Formulário de abertura</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Patrimônio</label>
              <input type="text" name="patrimony" id="patrimony" data-mask="000000" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-check align-form">
              <input type="checkbox" class="form-check-input" id="checkPatrimony">
              <label class="form-check-label">Não possui patrimônio</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Descrição</label>
              <textarea Maxlength="255" name="description" class="form-control"
                placeholder="Escreva uma breve descrição do problema ocorrido." rows="3" required></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Local</label>
              <select class="form-control" name="locale">
                @foreach($places as $place)
                <option value="{{ $place->id }}"> {{ $place->description }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Categoria</label>
              <select class="form-control" name="category">
                @foreach($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->description }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Observações</label>
              <textarea Maxlength="255" name="notes" class="form-control" placeholder="Observações quanto ao problema ocorrido."
                required rows="3"></textarea>
            </div>
          </div>
        </div>
        <button class="btn btn-danger" type="submit">Abrir chamado</button>
</section>

@stop
