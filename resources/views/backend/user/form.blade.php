            {{ csrf_field() }}      		
        	<div class="box-body">
        		<div class="col-md-6">
	          		<div class="form-group">
	            		<label for="exampleInputEmail1">Email address</label>
	                    <input name="email" value="{{ old('email',  isset($post->email) ? $post->email : null) }}" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
			        </div>
	          		@if(!isset($post->password))
	          		<div class="form-group">
	            		<label for="exampleInputEmail1">Password</label>
			            <input name="password" value="" class="form-control"  type="password">
			        </div>
	          		@endif
			        <div class="form-group">
	            		<label for="exampleInputEmail1">Name</label>
			            <input name="name" value="{{ old('name',  isset($post->name) ? $post->name : null) }}" class="form-control"  type="text">
			        </div>
					<div class="form-group">
            			<label for="exampleInputEmail1">Privilege </label>
						<input type="radio" name="privilege" value="administrator" @if(isset($post->privilege) && $post->privilege == 'administrator') checked @endif > Admin
						<input type="radio" name="privilege" value="standard" @if(isset($post->privilege) && $post->privilege != 'administrator') checked @endif > Standart<br>
					</div> 

			        @if(isset($post->password))
		          		<div class="form-group">
		            		<button type="button" id="reset-pass">Change Password</button>
		          		</div> 
	          		@endif
			        
          		</div>
          		<div class="col-md-6">
	          		<div class="form-group">   
	            		<label for="exampleInputFile">Upload Picture</label>
		          		<span class="img-temp"></span> 		
		          	@if(isset($post->image))
			      		<img src="{{ $post->image ==''?asset('backend/uploads/images/user-default.jpg'):asset(config('app.folder_upload_images') . '/' . $post->image) }}" class="old-img img-responsive">
					@else
		          		{!! old('imageView') !!}
	          		@endif
	          			<div id="progress" class="progress">
			          	<div class="bar" width="0"></div>
					    </div>
	            		<input type="hidden" class="inputImageView" name="imageView" value="{{ old('imageView') }}">
	            		<input type="hidden" class="inputImage" name="image" value="{{ old('image',  isset($post->image) ? $post->image : null) }}">
	            		<label class="img-upload-label">
	            			<input type="file" id="InputFileImage" name="images[]">Upload <span class="fa fa-download" aria-hidden="true"></span>
	            		</label>
	           			<p class="help-block small">No more than 1 MB of file size.</p>
		          	</div>
          		</div>
          		
        	</div>