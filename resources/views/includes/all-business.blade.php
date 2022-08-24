@php
  $business = App\Models\Subcontractor::all();
@endphp
@forelse ($business as $p)
  <tr data-id="{{$p->id}}" class="table-row">
    <td>{{$p->id}}</td>
    <td> <span style="display: none">{{$p->name}}</span> <input class="inline-fields main-fields" name="name" type="text" value="{{$p->name}}"> </td>
    <td> <span style="display: none">{{$p->email}}</span> <input class="inline-fields main-fields" name="email" type="text" value="{{$p->email}}"> </td>
    <td> <span style="display: none">{{$p->phone}}</span> <input class="inline-fields main-fields" name="phone" type="text" value="{{$p->phone}}"> </td>
    <td> <span style="display: none">{{$p->address}}</span> <input class="inline-fields main-fields" name="address" type="text" value="{{$p->address}}"> </td>
	  <td>
	    <button class="btn btn-sm btn-success" onclick="saveRow('{{$p->id}}')">{{trans('extra.save')}}</button>
	    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$p->id}}">{{trans('extra.delete')}}</button>

	  </td>
  </tr>
  <div class="modal fade" id="delete-row{{$p->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">{{trans('extra.delete_prompt_1')}}</div>
        <div class="modal-footer">
          <a href="{{url('deleteSubcontractor',$p->id)}}" class="btn btn-sm btn-success">{{trans('extra.yes')}}</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('extra.no')}}</button>
        </div>
      </div>
    </div>
  </div>
@empty
  <tr>
    <td colspan="6">{{trans('extra.empty')}}</td>
  </tr>
@endforelse