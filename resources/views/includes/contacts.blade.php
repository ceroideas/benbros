@foreach (App\Models\Contact::orderBy('id','desc')->where('contact_section_id',$contact_section_id)->get() as $c)
  <tr class="table-row" data-id="{{$c->id}}">
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="name" value="{{$c->name}}" type="text"></td>
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="last_name" value="{{$c->last_name}}" type="text"></td>
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="company" value="{{$c->company}}" type="text"></td>
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="email" value="{{$c->email}}" type="text"></td>
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="phone" value="{{$c->phone}}" type="text"></td>
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="position" value="{{$c->position}}" type="text"></td>
    <td><input onchange="saveRow('{{$c->id}}')" class="inline-fields main-fields" name="address" value="{{$c->address}}" type="text"></td>
    <td>
      <select onchange="saveRow('{{$c->id}}',this)" data-reload="true" class="inline-fields main-fields" name="contact_section_id">
        <option value="">Otros</option>
        @foreach (App\Models\ContactSection::all() as $cs)
          <option {{$c->contact_section_id == $cs->id ? 'selected' : ''}} value="{{$cs->id}}">{{$cs->name}}</option>
        @endforeach
      </select>
    </td>
    <td>
    	<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-contact-{{$c->id}}">{{trans('layout.delete')}}</button>
    </td>
  </tr>

  <div class="modal fade" id="delete-contact-{{$c->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">{{trans('layout.delete_prompt')}}</div>
        <div class="modal-footer">
          <a href="{{url('deleteContact',$c->id)}}" class="btn btn-sm btn-success">{{trans('layout.delete_confirm')}}</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('layout.delete_cancel')}}</button>
        </div>
      </div>
    </div>
  </div>
@endforeach