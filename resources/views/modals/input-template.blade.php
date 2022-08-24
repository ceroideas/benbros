<li class="create-input" style="position: relative; border-bottom: 1px solid #f0f0f0;">
	<span onclick="$(this).parent().remove()" style="position: absolute; top: 0; right: 0; cursor: pointer; z-index: 9999">x</span>
  <form action="{{url('saveInput')}}" method="POST" class="saveInput" enctype="multipart/form-data">
    <div class="creator">

      <div class="row">
      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>{{trans('builder.type')}}</label>
  	        <select name="type" class="form-control" onchange="changeType(this)">
  	          <option value="text">{{trans('builder.text')}}</option>
              <option value="number">{{trans('builder.number')}}</option>
              <option value="select">{{trans('builder.select')}}</option>
              <option value="document">{{trans('builder.doc')}}</option>
              <option value="textarea">{{trans('builder.textarea')}}</option>
              <option value="provinces">{{trans('builder.provinces')}}</option>
  	        </select>
  	      </div>
        </div>

      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>{{trans('builder.title')}}</label>
            <input type="text" name="title" class="form-control" required />
  	      </div>

  	      <div class="form-group">
  	        <label>{{trans('builder.placeholder')}}</label>
            <input type="text" name="placeholder" class="form-control" required />
  	      </div>

            <div class="form-group">
                <label for="info">{{trans('builder.info')}}</label>
                <textarea name="info" id="info" cols="30" rows="3" class="form-control"></textarea>
            </div>

            <div class="form-group">
              <label>{{trans('builder.show_lands')}}</label> <br>
              <input type="checkbox" checked name="status" />
            </div>

            <div class="form-group">
              <label>{{trans('builder.show_summary')}}</label> <br>
              <input type="checkbox" name="summary" />
            </div>

            <div class="form-group">
              <label>{{trans('builder.show_guarantee')}}</label> <br>
              <input type="checkbox" name="guarantee" />
            </div>
      	</div>
      </div>

      <div class="input-list">
	  </div>

    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-xs btn-success">{{trans('builder.accept')}}</button>
    </div>
  </form>
</li>