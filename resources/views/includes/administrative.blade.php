@php
  $administrative = App\Models\Administration::all();
@endphp
@forelse ($administrative as $a)
  <tr data-id="{{$a->id}}" class="table-row">
    <td>{{$a->id}}</td>
    <td> {{$a->name}} {{-- <input class="inline-fields main-fields" name="name" type="text" value="{{$a->name}}"> --}} </td>
    <td> {{$a->dni}} {{-- <input class="inline-fields main-fields" name="dni" type="text" value="{{$a->dni}}"> --}} </td>
    <td> {{$a->residence}} {{-- <input class="inline-fields main-fields" name="residence" type="text" value="{{$a->residence}}"> --}} </td>
    {{-- <td> {{$a->position}} <input class="inline-fields main-fields" name="position" type="text" value="{{$a->position}}"> </td>
    <td> {{$a->date}} <input class="inline-fields main-fields" name="date" type="text" value="{{$a->date}}"> </td> --}}
	  <td>
	    <a class="btn btn-sm btn-info" href="{{url('edit-administration',$a->id)}}">{{trans('layout.edit')}}</a>
      <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$a->id}}">{{trans('layout.delete')}}</button>

	  </td>
  </tr>

  <div class="modal fade" id="delete-row{{$a->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">{{trans('layout.delete_prompt')}}</div>
        <div class="modal-footer">
          <a href="{{url('deleteAdministration',$a->id)}}" class="btn btn-sm btn-success">{{trans('layout.delete_confirm')}}</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('layout.delete_cancel')}}</button>
        </div>
      </div>
    </div>
  </div>
@empty
  <tr>
    <td colspan="6">Empty list...</td>
  </tr>
@endforelse