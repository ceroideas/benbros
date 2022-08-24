@extends('layout')

@section('content')

<style>
  .inline-fields {
    min-width: 100%;
  }
</style>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('layout.adminis_body')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('layout.adminis_body')}}</li>
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
                <h3 class="card-title">{{trans('layout.reg_adminis_body')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>{{trans('layout.name')}}</th>
                    <th>{{trans('layout.dni')}}</th>
                    <th>{{trans('layout.residence')}}</th>
                    <th width="240px"></th>
                  </tr>
                  </thead>
                  <tbody id="all-partners">
                    @include('includes.administrative')
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>{{trans('layout.name')}}</th>
                    <th>{{trans('layout.dni')}}</th>
                    <th>{{trans('layout.residence')}}</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>

                <br>

                {{-- <button class="btn btn-danger float-right" style="margin-left: 4px;">Delete Row/Column</button> --}}
                <a href="{{url('new-administration')}}" class="btn btn-success float-right" style="margin-left: 4px;">{{trans('layout.add_new_column')}}</a>
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


<script>

  $("#example1").DataTable({
    "responsive": false, "lengthChange": false, "autoWidth": false,
  });
</script>

@endsection