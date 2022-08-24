@php
  $partners = App\Models\Partner::all();
@endphp
@forelse ($partners as $p)
  <tr data-id="{{$p->id}}" class="table-row">
    <td>{{$p->id}}</td>
    <td> <span style="display: none">{{$p->name}}</span> <input class="inline-fields main-fields" name="name" type="text" value="{{$p->name}}"> </td>
	  <td>
	    <button class="btn btn-sm btn-success" onclick="saveRow('{{$p->id}}')">{{trans('layout.save')}}</button>
	    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$p->id}}">{{trans('layout.delete')}}</button>

	  </td>
  </tr>
  <div class="modal fade" id="delete-row{{$p->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">{{trans('layout.delete_prompt')}}</div>
        <div class="modal-footer">
          <a href="{{url('deletePartner',$p->id)}}" class="btn btn-sm btn-success">{{trans('layout.delete_confirm')}}</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('layout.delete_cancel')}}</button>
        </div>
      </div>
    </div>
  </div>
@empty
  <tr>
    <td colspan="3">Empty list...</td>
  </tr>
@endforelse