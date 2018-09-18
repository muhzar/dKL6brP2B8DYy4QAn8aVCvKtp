            {{ csrf_field() }}      		
        	<div class="box-body">
          		<div class="col-md-6">
	          		<div class="form-group">
	            		<label for="exampleInputPassword1">Title</label>
	            		<input name="title" value="{{ old('title',  isset($post->title) ? $post->title : null) }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="Title">
	          		</div>
	          		<div class="form-group">
	            		<label for="exampleInputPassword1"><small>Slug [optional]</small></label>
	            		<input name="slug" value="{{ old('slug',  isset($post->slug) ? $post->slug : null) }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="Slug">
	          		</div>
	          		<div class="form-group">
	            		<label for="exampleInputFile">Category</label>
	            		<select name="parent_id">
	            			@foreach( $categories as $category)
	            				<option value="{{ $category->id }}">{{ $category->title }}</option>
	            			@endforeach
	            		</select>
		          	</div> 
		          	<div class="form-group">
	            		<label for="exampleInputFile">Status</label>
	            		<select name="status">
            				<option value="0">Unpublish</option>
            				<option value="1">Publish</option>
	            		</select>
		          	</div> 
          		</div>
          		<div class="col-md-6">
	          		   
		          	<div class="form-group">   		
		          	@if(isset($post->image))
			      		<img src="{{ $post->image ==''?asset('backend/uploads/images/user-default.jpg'):asset('backend/uploads/images/' . $post->image) }}" width="100" height="100">
					@endif	
					</div>
	          		<div class="form-group">
	            		<label for="exampleInputFile">Upload Picture</label>
	            		<input type="file" id="InputFileImage" name="image">
	           			<p class="help-block">No more than 1Mb.</p>
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
        	</div>