            {{ csrf_field() }} 	
        	<div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1"><small>Name</small></label>
                        <input name="name" value="{{ old('name',  isset($post->name) ? $post->name : null) }}" type="text" class="form-control slug" id="exampleInputPassword1" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><small>Start At</small></label>
                        <input name="start_at" value="{{ old('start_at',  isset($post->start_at) ? substr($post->start_at, 0, 5) : null) }}" type="text" class="form-control slug" id="exampleInputPassword1" placeholder="start at">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><small>End At</small></label>
                        <input name="end_at" value="{{ old('end_at',  isset($post->end_at) ? substr($post->end_at, 0, 5) : null) }}" type="text" class="form-control slug" id="exampleInputPassword1" placeholder="end at">
                    </div>
                </div>
          		<div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <textarea class="editor-class" name="description">{{ old('description',  isset($post->description) ? $post->description : null) }} </textarea>
                    </div>
          		</div>
        	</div>