@extends('layout')

@section('content')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>
	.div-picture {
		width: 100%;
		height: 200px;
		background-size: cover;
		background-position: center;
		background-color: #f1f1f1;
		border-radius: 12px;
	}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Mi Perfil</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('adminlte')}}/#">Home</a></li>
          <li class="breadcrumb-item active">Mi Perfil</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
<div class="container-container">
  <div class="content container-fluid bootstrap snippets bootdey">
  	<form method="POST" class="profile-form card">
  		{{csrf_field()}}
  		<input type="hidden" name="id" value="{{Auth::id()}}">
  		<div class="card-body">
  			
	      <div class="row">

	      	<div class="col-sm-4">
	      		
	      		<label>Foto de perfil

	      		<div class="div-picture" style="margin-bottom: 12px; background-image: url('{{url('uploads/avatars',Auth::user()->avatar)}}');;">
	      			
	      		</div>
		      	<div class="form-group">
		      		<input type="file" name="avatar" class="form-control">
		      	</div>
		      	</label>
	      	</div>

	      </div>

	      <div class="row">

	      	<div class="col-sm-4">
		      	<div class="form-group">
		      		<label>Nombre</label>
		      		<input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
		      	</div>
	      	</div>

	      	<div class="col-sm-4">
		      	<div class="form-group">
		      		<label>Email</label>
		      		<input type="email" name="email" class="form-control" value="{{Auth::user()->email}}">
		      	</div>
	      	</div>

	      	<div class="col-sm-4">
		      	<div class="form-group">
		      		<label>Cargo</label>
		      		<input type="text" name="position" class="form-control" value="{{Auth::user()->position}}">
		      	</div>
	      	</div>

	      	<div class="col-sm-4">
		      	<div class="form-group">
		      		<label>Contraseña (Dejar en blanco para no cambiar)</label>
		      		<input type="password" name="password" class="form-control">
		      	</div>
	      	</div>

	      	<div class="col-sm-4">
		      	<div class="form-group">
		      		<label>Repetir Contraseña</label>
		      		<input type="password" name="password_confirmation" class="form-control">
		      	</div>
	      	</div>

	      	<div class="col-sm-12">
	      		<button type="submit" class="btn btn-sm btn-info">Guardar</button>
	      	</div>
	        
	      </div>
  		</div>
  	</form>
    </div>
 </div>
</section>

@endsection

@section('scripts')
  	<script>
	    $(".profile-form").submit(function(e){
	        e.preventDefault();

	        var formData = new FormData($(this)[0]);

	        $.ajax({
	        	type: "POST",
	            processData: false,
	            contentType: false,
	            url: '{!! URL::to("updateProfile") !!}',
	            dataType: "json",
	            data: formData,
	        })
	        .done(function() {
	        	console.log('guardado');
                var notice = PNotify.success({
		            title: "Exito",
		            text: "La información se ha guardado correctamente",
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
	        .fail(function(e) {
	        	let html = "";
	        	if (e.responseJSON) {

	            	for (var i in e.responseJSON.errors) {
	            		html+= "-"+e.responseJSON.errors[i]+"<br>"
	            	}
	            	var notice = PNotify.error({
			            title: "Ha ocurrido un error",
			            text: html,
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
			      /**/
	        	}
	        })
	        .always(function() {
	        	console.log("complete");
	        });
	    })

	    $('input[type=file]').change(function (e) {
	    	e.preventDefault();
	    	previewFile();
	    });

	    function previewFile() {
		  const preview = document.querySelector('.div-picture');
		  const file = document.querySelector('input[type=file]').files[0];
		  const reader = new FileReader();

		  reader.addEventListener("load", function () {
		    // convierte la imagen a una cadena en base64
		    $(preview).css('background-image', 'url('+reader.result+')');
		    $('.img-circle.elevation-2').css('background-image', 'url('+reader.result+')');
		  }, false);

		  if (file) {
		    reader.readAsDataURL(file);
		  }
		}
	</script>

@stop