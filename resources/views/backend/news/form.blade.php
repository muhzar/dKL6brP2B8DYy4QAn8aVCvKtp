            {{ csrf_field() }} 	
        	<div class="box-body">
          		<div class="col-md-6">
	          		<div class="form-group">
	            		<label for="exampleInputPassword1">Title</label>
	            		<input name="title" value="{{ old('title',  isset($post->title) ? $post->title : null) }}" type="text" class="form-control title" id="exampleInputPassword1" placeholder="Title">
	          		</div>
	          		<div class="form-group">
	            		<label for="exampleInputPassword1"><small>Slug [optional]</small></label>
	            		<input name="slug" value="{{ old('slug',  isset($post->slug) ? $post->slug : null) }}" type="text" class="form-control slug" id="exampleInputPassword1" placeholder="Slug">
	          		</div>
	          		<div class="form-group">
	            		<label for="exampleInputFile">Channel</label>
	            		<select name="category_id">
	            			@foreach( $categories as $category)
	            				@if(isset($post))
	            					<option value="{{ $category->id }}" {{ $post->category->category_id == $category->id? 'selected="selected"':'' }}>{{ $category->title }}</option>
	            				@else
	            					<option value="{{ $category->id }}">{{ $category->title }}</option>
	            					@endif
	            			@endforeach
	            		</select>
		          	</div> 
		          	<div class="form-group">
	            		<label for="exampleInputFile">Status</label>
	            		<select name="status">
	            			<?php $status = old('status',  isset($post->status) ? $post->status : null);?>
            				<option value="0" {{ $status == '0'? 'selected="selected"':'' }}>Unpublish</option>
            				<option value="1" {{ $status == '1'? 'selected="selected"':'' }}>Publish</option>
	            		</select>
		          	</div> 
          		</div>
          		<div class="col-md-6">
          			<div class="form-group" id='datetimepicker'>
	            		<label for="exampleInputFile">Published Date</label>
	            		<input type="text" id="publishedDate" name="publishedDate" value="{{ old('published_at',  isset($post->published_at) ? date('Y-m-d', strtotime($post->published_at)) : date('Y-m-d')) }}">
		          	</div>
	          		   
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
          		<div class="col-md-12">
	          		<div class="form-group">
	            		<label for="exampleInputPassword1">Summary</label>
	            		<textarea class="editor-class" name="summary">{{ old('summary',  isset($post->summary) ? $post->summary : null) }}</textarea>
	          		</div>
	          		<div class="form-group">
	            		<label for="exampleInputPassword1">Content</label>
            			<textarea class="editor-class" name="content">{{ old('content',  isset($post->content) ? $post->content : null) }}</textarea>
	          		</div>
          		</div>
          		<div class="custom-fields">
	          		<div class="col-md-12">
	            		<label for="exampleInputPassword1">Custom Fields</label>
	        		</div>
          		</div>
          		@if(isset($customFields))
	          		@foreach($customFields as $customField)
	          			<div class="custom-field col-md-12" style="padding-bottom:10px;">
	          				<div class="col-md-6">
	          					<div class="form-group">
	          						<div class="col-md-6">
	          							<input name="custom-field-name[]" value="{{ $customField->name }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="Custom field name" required="">
	          						</div>
	          						<div class="col-md-6">
		          						<input name="custom-field-value[]" value="{{ $customField->value }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="Custom field value" required="">
		          						<label class="myLabel"><input id="fileupload" type="file" name="images[]" class="custom-img"><span class="fa fa-download" aria-hidden="true"></span></label>
		          						<a href="#" class="delete-custom-field"><span class="fa fa-trash" aria-hidden="true"></a>
		          					</div>
		          				</div>
		          			</div>
		          		</div>
	          		@endforeach
          		@endif
          		<div class="col-md-12">
	          		<div class="add-custom-field"><span><a href="#" class="btn-add-custom-field">add custom field</a></span></div>
          		</div>
        	</div>