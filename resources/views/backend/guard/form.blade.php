            {{ csrf_field() }}      		
        	<div class="box-body">
        		<div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">User ID</label>
                        <input name="username" value="{{ old('username',  isset($post->username) ? $post->username : null) }}" class="form-control"  type="text">
                    </div>
			        <div class="form-group">
	            		<label for="exampleInputEmail1">Name</label>
			            <input name="name" value="{{ old('name',  isset($post->name) ? $post->name : null) }}" class="form-control"  type="text">
			        </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input name="password" value="{{ old('password',  isset($post->password) ? $post->password : null) }}" class="form-control"  type="text">
                    </div>
                    
          		</div>
          		
        	</div>