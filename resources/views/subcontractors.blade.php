@extends('layout')

@section('content')

<style>
  .inline-fields {
    min-width: 100%;
  }
  .mydocument {
    display: none;
  }
</style>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('extra.subcontrators')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('extra.subcontrators')}}</li>
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
                <h3 class="card-title">{{trans('extra.business_reg')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>{{trans('extra.name')}}</th>
                    <th>{{trans('extra.email')}}</th>
                    <th>{{trans('extra.phone')}}</th>
                    <th>{{trans('extra.address')}}</th>
                    <th width="240px"></th>
                  </tr>
                  </thead>
                  <tbody id="all-business">
                    @include('includes.all-business')
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>

                <br>

                {{-- <button class="btn btn-danger float-right" style="margin-left: 4px;">Delete Row/Column</button> --}}
                <button class="btn btn-success float-right" id="add-partner" style="margin-left: 4px;">+{{trans('extra.add_column')}}</button>
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

  $('#add-partner').click(function (e) {
    e.preventDefault();

    console.log('add-partner');

    $.get('{{url('addSubcontractor')}}', function(data, textStatus) {
      $('#all-business').html(data);
    });
  });

  $("#example1").DataTable({
    "responsive": false, "lengthChange": false, "autoWidth": false,
  });

  function saveRow(id)
  {
    var formData = new FormData();
    var extra = [];

    $.each($('.table-row[data-id="'+id+'"] .main-fields'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveSubcontractor')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      console.log(data);

      var notice = PNotify.success({
            title: "{{trans('extra.completed')}}",
            text: "{{trans('extra.message')}}",
            textTrusted: true,
            modules: {
              Buttons: {
                closer: false,
                sticker: false,
              }
            }
          })
      notice.on('click', function() {
        notice.close();
      });
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  $('.mydocument').change(function (e) {
      e.preventDefault();

      let type = $(this).data('type');
      let id = $(this).data('id');
      let fd = new FormData();

      fd.append('document',$(this)[0].files[0]);
      fd.append('_token','{{csrf_token()}}');
      fd.append('id',id);
      fd.append('type',type);

      $.ajax({
        url: '{{url('saveSubcontractorDocument')}}',
        contentType: false,
        processData: false,
        type: 'POST',
        data: fd,
      })
      .done(function(data) {
        $('#docs-'+type+'-'+id).html(data);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });

  function changeDocumentStatus(i,j)
  {
    console.log(i,j.value);

    $.post('{{url('changeDocumentStatus')}}', {_token: '{{csrf_token()}}', id: i, value: j.value}, function(data, textStatus, xhr) {
      
    });
  }
</script>

@endsection