<style>
	.progress-number {
		display: block;
		position: absolute;
		top: 0;
		bottom: 0;
		width: 100%;
		margin: auto;
		height: fit-content;
		text-align: center;
		color: #fff;
		text-shadow: 2px 0 0 #333, -2px 0 0 #333, 0 2px 0 #333, 0 -2px 0 #333, 1px 1px #333, -1px -1px 0 #333, 1px -1px 0 #333, -1px 1px 0 #333;
		z-index: 1;
	}
</style>
@foreach (App\Models\ActivitySection::where('permission_id',$p->id)->get() as $as)
	<tr style="display: none;" id="show-{{$as->id}}">
	  	<td colspan="10" style="position: relative;">
	  		<i class="fas fa-eye show-tr" data-id="{{$as->id}}" style="/*position: absolute; top: 8px; left: 8px;*/ cursor: pointer;"></i>
	  		{{$as->name}}
	  	</td>
	 </tr>
	@forelse ($as->activities as $key => $act)
	{{-- <tbody> --}}
	  <tr data-id="{{$act->id}}" class="table-row hide-{{ $as->id }}">
	  	@if ($key == 0)
		  	<td class="no-hover" rowspan="{{ $as->activities->count() }}" style="vertical-align: middle; position: relative;">
		  		<i class="fas fa-eye-slash hide-tr" data-id="{{$as->id}}" style="position: absolute; top: 8px; left: 8px; cursor: pointer;"></i>
		  		<div contenteditable onblur="saveSection(this)" data-id="{{$as->id}}" style="position: relative;">
		  			{{$as->name}}
		  		</div>
		  	</td>
		  @else
		  	<td style="display: none">
		  	</td>
	  	@endif
	    <td><input onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" style="width: 100%;" name="name" type="text" value="{{$act->name}}"></td>
	    <td style="width: 300px !important">
    			<div class="input-group" style="min-width: 300px;">
	    			<input id="file-{{$act->id}}" type="file" name="file" class="document form-control" required>

	    			<button type="button" onclick="uploadFile(this)" data-action="{{url('uploadFile')}}" data-id="{{$act->id}}" class="btn btn-info">Save</button>
    			</div>
	    	@foreach (App\Models\ActivityDocument::where('activity_id',$act->id)->get() as $ad)
	    		<li style="display: block; width: 250px; text-overflow: ellipsis; white-space: nowrap; font-weight: normal !important; overflow: hidden;"> <a target="_blank" href="{{url('uploads/documents/activities',$ad->url)}}">{{$ad->url}}</a> </li>
	    	@endforeach
	    </td>
	    <td>
	    	<div style="height: 40px; width: 200px; position: relative; overflow: hidden; border-radius: 8px; border: 1px solid #c1c1c1; position: relative;">
	    		
	    		<span class="progress-number" id="prog{{$act->id}}">{{$act->progress ? $act->progress : '0'}}%</span>
	    		<div id="progress{{$act->id}}" style="background: -webkit-linear-gradient(left,lightblue,blue); height: 40px; width: {{$act->progress ? $act->progress.'%' : '0%'}}; position: absolute; top: 0;">
	    		</div>
	    		<input type="range" name="progress" id="range{{$act->id}}" class="form-control main-fields" onchange="changeWidth('{{$act->id}}',event)" value="{{ $act->progress ? $act->progress : '0' }}" min="0" max="100" style="padding-left: 0; padding-right: 0; position: relative; z-index: 1; opacity: 0;">
	    	</div>
	    </td>
	    <td><input type="date" name="start_date" onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" value="{{$act->start_date}}"></td>
	    <td><input type="date" name="end_date" onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" value="{{$act->end_date}}"></td>
	    <td><input type="text" name="responsable_benbros" onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" value="{{$act->responsable_benbros}}"></td>
	    <td><input type="text" name="responsable_external" onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" value="{{$act->responsable_external}}"></td>
	    <td><input type="text" name="administrative" onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" value="{{$act->administrative}}"></td>
	    <td> <textarea name="commentary" onchange="saveRow('{{$act->id}}')" class="inline-fields textarea" rows="4"></textarea> </td>
	    {{-- <td></td>
	    <td><input type="date" name="real_date" onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" value="{{$act->real_date}}"></td> --}}
	    {{-- <td>
	    	<select onchange="saveRow('{{$act->id}}')" class="inline-fields main-fields" name="status">
		      <option value="" selected disabled></option>
		      <option {{$act->status == 1 ? 'selected' : ''}} value="1">Not Started</option>
		      <option {{$act->status == 2 ? 'selected' : ''}} value="2">In Progress</option>
		      <option {{$act->status == 3 ? 'selected' : ''}} value="3">Finished</option>
		    </select>
	    </td> --}}
	    <td>
	    	
	    	{{-- <button class="btn btn-sm btn-success" onchange="saveRow('{{$act->id}}')">Save</button> --}}
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$act->id}}">Delete</button>

        </td>
  	  </tr>
	{{-- </tbody> --}}

	  <div class="modal fade" id="delete-row{{$act->id}}">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">Delete this row?</div>
	        <div class="modal-footer">
	          <a href="{{url('deleteActivity',$act->id)}}" class="btn btn-sm btn-success">Yes, Delete</a>
	          <button class="btn btn-sm btn-warning" data-dismiss="modal">Cancel</button>
	        </div>
	      </div>
	    </div>
	  </div>
	@empty
		<tr>
				<td style="vertical-align: middle;">
		  		<div contenteditable onblur="saveSection(this)" data-id="{{$as->id}}">
		  			{{$as->name}}
		  		</div>
		  	</td>
		</tr>
	@endforelse
	<tr>
		<td colspan="10"></td>
	</tr>
@endforeach