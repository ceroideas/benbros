@extends('layout')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Apoderados</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Apoderados</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Apoderados Registrados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Residencia</th>
                    <th>Poder General</th>
                    <th>Poder Especial</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>ejemplo</td>
                    <td>6545434321</td>
                    <td>Madrid</td>
                    <td>Cargo de ejemplo 1</td>
                    <td>Cargo de ejemplo 2</td>
                    <td>
                    	<button class="btn btn-sm btn-primary">Ver</button>
                    	<button class="btn btn-sm btn-success">Editar</button>
                    	<button class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                  </tr>
                  <tr>
                    <td>ejemplo</td>
                    <td>6545434321</td>
                    <td>Madrid</td>
                    <td>Cargo de ejemplo 1</td>
                    <td>Cargo de ejemplo 2</td>
                    <td>
                    	<button class="btn btn-sm btn-primary">Ver</button>
                    	<button class="btn btn-sm btn-success">Editar</button>
                    	<button class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                  </tr>
                  <tr>
                    <td>ejemplo</td>
                    <td>6545434321</td>
                    <td>Madrid</td>
                    <td>Cargo de ejemplo 1</td>
                    <td>Cargo de ejemplo 2</td>
                    <td>
                    	<button class="btn btn-sm btn-primary">Ver</button>
                    	<button class="btn btn-sm btn-success">Editar</button>
                    	<button class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Residencia</th>
                    <th>Poder General</th>
                    <th>Poder Especial</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>

                <br>

                <button class="btn btn-danger float-right" style="margin-left: 4px;">Delete Row/Column</button>
                <button class="btn btn-success float-right" style="margin-left: 4px;">+ Add new Column</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

@endsection

@section('scripts')

<script type="text/javascript" src="{{url('/')}}/jscharting.js"></script>

<link rel="stylesheet" type="text/css" href="css/default.css" />

@endsection