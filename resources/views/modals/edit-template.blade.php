<li class="create-input" style="position: relative; border-bottom: 1px solid #f0f0f0">
	<span onclick="$(this).parent().remove()" style="position: absolute; top: 0; right: 0; cursor: pointer; z-index: 9999">x</span>
  <form action="{{url('editInput')}}" method="POST" class="saveInput" enctype="multipart/form-data">
    <div class="creator">

    	<input type="hidden" name="id" value="{{$inp->id}}">

      <div class="row">
      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>{{trans('builder.type')}}</label>
  	        <select name="type" class="form-control" onchange="changeType(this)">
  	          {{-- <option value="text">Texto</option> --}}
  	          <option {{$inp->type == 'text' ? 'selected' : ''}} value="text">{{trans('builder.text')}}</option>
  	          <option {{$inp->type == 'number' ? 'selected' : ''}} value="number">{{trans('builder.number')}}</option>
  	          <option {{$inp->type == 'select' ? 'selected' : ''}} value="select">{{trans('builder.select')}}</option>
              <option {{$inp->type == 'document' ? 'selected' : ''}} value="document">{{trans('builder.doc')}}</option>
              <option {{$inp->type == 'textarea' ? 'selected' : ''}} value="textarea">{{trans('builder.textarea')}}</option>
              <option {{$inp->type == 'provinces' ? 'selected' : ''}} value="provinces">{{trans('builder.provinces')}}</option>
  	        </select>
  	      </div>
        </div>

      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>{{trans('builder.title')}}</label>
            <input type="text" name="title" class="form-control" value="{{$inp->title}}" required />
  	      </div>

  	      <div class="form-group">
  	        <label>{{trans('builder.placeholder')}}</label>
            <input type="text" name="placeholder" class="form-control" value="{{$inp->placeholder}}" required />
  	      </div>

            <div class="form-group">
                <label for="info">{{trans('builder.info')}}</label>
                <textarea name="info" id="info" cols="30" rows="3" class="form-control">{{$inp->info}}</textarea>
            </div>

            <div class="form-group">
              <label>{{trans('builder.show_lands')}}</label> <br>
              <input type="checkbox" name="status" {{$inp->status ? 'checked' : ''}}/>
            </div>

            <div class="form-group">
	  	        <label>{{trans('builder.show_summary')}}</label> <br>
	            <input type="checkbox" name="summary" {{$inp->summary ? 'checked' : ''}} />
	  	      </div>

	  	      <div class="form-group">
	  	        <label>{{trans('builder.show_guarantee')}}</label> <br>
	            <input type="checkbox" name="guarantee" {{$inp->guarantee ? 'checked' : ''}} />
	  	      </div>

	  	      <div class="form-group">
              <label>{{trans('builder.show_development')}}</label> <br>
              <input type="checkbox" name="development" {{$inp->development ? 'checked' : ''}}/>
            </div>
      	</div>
      </div>

      <div class="input-list">
			@if ($inp->options->count() > 0)

			<div class="form-group">
				<label style="display:block; width: 100%; margin-bottom: 15px">{{trans('builder.add_option')}} <button type="button" onclick="addOption(this)" class="btn btn-xs btn-success pull-right" type=""><i class="fa fa-plus"></i></button></label>
				<ul class="option-list" style="padding-left: 20px">
					@foreach ($inp->options as $op)
					<li class="option-li">
					<div class="input-group mb-3">
						<input type="text" name="options[]" required class="form-control" placeholder="Opción" value="{{$op->option}}"/>
						<div class="input-group-append">
							<button onclick="removeOption(this)" type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
						</div>
					</div>
					</li>
					@endforeach
				</ul>
			</div>
			@endif
	  </div>

    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-xs btn-success">{{trans('builder.accept')}}</button>
    </div>
  </form>
</li>