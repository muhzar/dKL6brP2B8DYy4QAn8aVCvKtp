            {{ csrf_field() }}      		
        	<div class="box-body">
        		<div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cluster</label>
                        <select name="cluster_id">
                            @foreach( $clusters as $cluster)
                                @if(isset($post))
                                    <option value="{{ $cluster->id }}" {{ $post->cluster->id == $cluster->id? 'selected="selected"':'' }}>{{ $cluster->name }}</option>
                                @else
                                    <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                                    @endif
                            @endforeach
                        </select>
                        
	            		<label for="exampleInputEmail1">Guard</label>
			            <select name="guard_id">
                            @foreach( $guards as $guard)
                                @if(isset($post))
                                    <option value="{{ $guard->id }}" {{ $post->guards->id == $guard->id? 'selected="selected"':'' }}>{{ $guard->name }}</option>
                                @else
                                    <option value="{{ $guard->id }}">{{ $guard->name }}</option>
                                    @endif
                            @endforeach
                        </select>
			        </div>
                    
          		</div>
          		
        	</div>