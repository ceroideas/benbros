@extends('layout')

@section('content')

{{-- <link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('extra.contacts')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('extra.contacts')}}</li>
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
                <h3 class="card-title">{{trans('extra.contacts_table')}}</h3>

                <div style="clear: both;"></div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="accordion" id="accordionExample">

                  @foreach (App\Models\ContactSection::all() as $s)
                    <div class="card">
                      <div class="card-header">
                        <h2 class="mb-0">
                          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$s->id}}" aria-expanded="true" aria-controls="collapse-{{$s->id}}">
                            <span class="updateSection" contenteditable="true" data-id="{{$s->id}}">{{$s->name}}</span>


                            <span data-toggle="modal" data-target="#delete-{{$s->id}}" style="float: right;" onclick="this.stopPropagation()">x</span>

                          </button>
                        </h2>

                        <div class="modal fade" id="delete-{{$s->id}}">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">{{trans('extra.delete_prompt')}}</div>
                              <div class="modal-footer">
                                <a href="{{url('deleteSection',$s->id)}}" class="btn btn-sm btn-success">Si</a>
                                <button data-dismiss="modal" class="btn btn-sm btn-warning">No</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="collapse-{{$s->id}}" class="collapse show" data-parent="#accordionExample">
                        <div class="card-body">
                          <table id="example2-" class="table table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                              <th>{{trans('extra.name')}}</th>
                              <th>{{trans('extra.last_name')}}</th>
                              <th>{{trans('extra.company')}}</th>
                              <th>{{trans('extra.email')}}</th>
                              <th>{{trans('extra.phone')}}</th>
                              <th>{{trans('extra.position')}}</th>
                              <th>{{trans('extra.address')}}</th>
                              <th>{{trans('extra.category')}}</th>
                              <th></th>
                            </tr>
                            </thead>
                            <tbody id="all-contacts-{{$s->id}}">
                              @include('includes.contacts', ['contact_section_id' => $s->id])
                            </tbody>
                            {{-- <tfoot>
                            <tr>
                              <th>Name</th>
                              <th>Last Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Address</th>
                              <th>Category</th>
                              <th></th>
                            </tr>
                            </tfoot> --}}
                          </table>

                          <br>

                          <button class="add-contact btn btn-success btn-xs float-right" data-toggle="modal" data-id="{{$s->id}}" style="margin-left: 4px;">{{trans('extra.add_contact')}}</button>
                        </div>
                      </div>
                    </div>
                  @endforeach
                  
                  <div class="card">
                    <div class="card-header">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOthers" aria-expanded="true" aria-controls="collapseOthers">
                          {{trans('extra.other')}}
                        </button>
                      </h2>
                    </div>

                    <div id="collapseOthers" class="collapse show" data-parent="#accordionExample">
                      <div class="card-body">
                        <table id="example2-" class="table table-bordered table-hover table-responsive">
                          <thead>
                          <tr>
                              <th>{{trans('extra.name')}}</th>
                              <th>{{trans('extra.last_name')}}</th>
                              <th>{{trans('extra.company')}}</th>
                              <th>{{trans('extra.email')}}</th>
                              <th>{{trans('extra.phone')}}</th>
                              <th>{{trans('extra.position')}}</th>
                              <th>{{trans('extra.address')}}</th>
                              <th>{{trans('extra.category')}}</th>
                            <th></th>
                          </tr>
                          </thead>
                          <tbody id="all-contacts">
                            @include('includes.contacts', ['contact_section_id' => null])
                          </tbody>
                          {{-- <tfoot>
                          <tr>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Category</th>
                            <th></th>
                          </tr>
                          </tfoot> --}}
                        </table>
                      </div>
                    </div>
                  </div>
                  
                </div>


                <br>

                {{-- <button class="btn btn-danger float-right" style="margin-left: 4px;">Delete Row/Column</button> --}}
                <button class="btn btn-warning float-right" id="add-section" style="margin-left: 4px;">{{trans('extra.add_section')}}</button>
                {{-- <button class="add-contact btn btn-success float-right" data-toggle="modal" style="margin-left: 4px;">{{trans('extra.add_row')}}</button> --}}

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


    {{-- <div class="modal fade" id="builder-2">
  
      <div class="modal-dialog">
        <form class="modal-content" action="{{url('addNewGuarantee')}}" method="POST">
          {{csrf_field()}}
          <div class="modal-header">
            Select project
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                        <label>Project</label>

                  <select name="land_id" class="form-control" required>
                    @foreach (App\Models\Land::whereNotExists(function($q){
                      $q->from('endorsements')
                        ->whereRaw('endorsements.land_id = lands.id');
                    })->where('name','!=','')->get() as $land)

                              <option value="{{$land->id}}">{{$land->name}}</option>
                      
                    @endforeach
                        </select>

                      </div>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-success">Aceptar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>

    </div> --}}

@endsection

@section('scripts')

{{-- <link rel="stylesheet" href="{{url('datatables/datatables.min.css')}}"> --}}
{{-- <script src="{{url('datatables/datatables.min.js')}}"></script> --}}

<script>
  // $.each($('.content select'), function(index, val) {
  //   $(this)[0].selectedIndex = Math.floor(Math.random() * ($(this).find('option').length - 0) -1);
  // });

  $(function () {
        $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $('.add-contact').click(function (e) {
  	e.preventDefault();
    e.stopPropagation()

    let id = $(this).data('id');

    if (id) {
      $.get('{{url('addContact')}}/'+id, function(data, textStatus) {
        $('#all-contacts-'+id).html(data);
      });
    }else{
    	$.get('{{url('addContact')}}', function(data, textStatus) {
    		$('#all-contacts').html(data);
    	});
    }

  });

  $('#add-section').click(function (e) {
    e.preventDefault();

    $.get('{{url('addSection')}}', function(data, textStatus) {
      location.reload();
    });
  });

  $('.updateSection').on('keyup',function (e) { e.stopPropagation(); });
  $('.updateSection').on('keydown',function (e) { e.stopPropagation(); });
  $('.updateSection').on('change',function (e) { e.stopPropagation(); });
  $('.updateSection').on('click',function (e) { e.stopPropagation(); });
  $('.updateSection').on('focus',function (e) { e.stopPropagation(); });

  $('.updateSection').on('blur',function (e) {
    e.preventDefault();
    e.stopPropagation();

    $.post('{{url('updateSection')}}', {_token: '{{csrf_token()}}', name: $(this).text(), id: $(this).data('id')} , function(data, textStatus) {
      console.log('completado');
    });
  });

  function saveRow(id,element = null)
  {
    var formData = new FormData();
    var extra = [];
    var reload = $(element).data('reload');

    $.each($('.table-row[data-id="'+id+'"] .main-fields'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    // $.each($('.table-row[data-id="'+id+'"] .extra-fields'), function(index, val) {
    //    extra.push({id:$(this).attr('name'),value:$(this).val()});
    // });

    // formData.append('extras',JSON.stringify(extra));
    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveContact')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function() {
      if (reload) {
        location.reload();
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }
</script>
@endsection