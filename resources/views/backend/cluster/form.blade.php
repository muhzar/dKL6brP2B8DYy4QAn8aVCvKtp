            {{ csrf_field() }}      		
        	<div class="box-body">
        		<div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Code</label>
                        <input name="code" value="{{ old('code',  isset($post->code) ? $post->code : null) }}" class="form-control code"  type="text">
                    </div>
			        <div class="form-group">
	            		<label for="exampleInputEmail1">Name</label>
			            <input name="name" value="{{ old('name',  isset($post->name) ? $post->name : null) }}" class="form-control name"  type="text">
			        </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Latitude</label>
                        <input name="latitude" value="{{ old('latitude',  isset($post->latitude) ? $post->latitude : null) }}" class="form-control"  type="text">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Longitude</label>
                        <input name="longitude" value="{{ old('longitude',  isset($post->longitude) ? $post->longitude : null) }}" class="form-control"  type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea class="editor-class" name="description">{{ old('description',  isset($post->description) ? $post->description : null) }}</textarea>
                    </div>
          		</div>
          		
        	</div>