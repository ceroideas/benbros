<li class="create-input" style="position: relative; border-bottom: 1px solid #f0f0f0">
	<span onclick="$(this).parent().remove()" style="position: absolute; top: 0; right: 0; cursor: pointer; z-index: 9999">x</span>
  <form action="{{url('editPermissionInput')}}" method="POST" class="saveInput" enctype="multipart/form-data">
    <div class="creator">

      <input type="hidden" name="id" value="{{$inp->id}}">

      <div class="row">
      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>Sección</label>
  	        <select name="section_id" class="form-control">
  	          @foreach (App\Models\Section::all() as $sect)
                <option {{$sect->id == $inp->section_id}} value="{{$sect->id}}">{{$sect->name}}</option>
              @endforeach
  	        </select>
  	      </div>
          <div class="form-group">
            <div class="form-group">
            <label>Nueva sección (si no está creada se añadirá al listado)</label>
            <input type="text" name="new_section" class="form-control" />
          </div>
          </div>
        </div>

      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>Título</label>
            <input type="text" name="title" class="form-control" required value="{{$inp->title}}" />
  	      </div>

          <div class="form-group">
              <label for="info">Información</label>
              <textarea name="info" id="info" cols="30" rows="3" class="form-control">{{$inp->info}}</textarea>
          </div>
      	</div>
      </div>

    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-xs btn-success">Aceptar</button>
    </div>
  </form>
</li>