            {{ csrf_field() }}      		
        	<div class="box-body">
        		<div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Code</label>
                        <input name="code" value="{{ old('code',  isset($post->code) ? $post->code : null) }}" class="form-control"  type="text">
                    </div>
			        <div class="form-group">
	            		<label for="exampleInputEmail1">Name</label>
			            <input name="name" value="{{ old('name',  isset($post->name) ? $post->name : null) }}" class="form-control"  type="text">
			        </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cluster</label>
                        <select name="cluster_code">
                            @foreach( $clusters as $cluster)
                                @if(isset($post))
                                    <option value="{{ $cluster->code }}" {{ $post->cluster_code == $cluster->code? 'selected="selected"':'' }}>{{ $cluster->name }}</option>
                                @else
                                    <option value="{{ $cluster->code }}">{{ $cluster->name }}</option>
                                    @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Coordinate Points [ <a href="" class="add-point">add</a> ]</label>
                        <table class="tbl-route">
                            <tbody>
                                <tr>
                                    <th width="100">Order</th>
                                    <th width="150">Code</th>
                                    <th width="150">Latitude</th>
                                    <th width="150">Longitude</th>
                                    <th width="150">Description</th>
                                    <th width="150">Beacon ID</th>
                                    <th width="150">Action</th>
                                </tr>
                                @foreach( $points as $point)
                                    <tr>
                                        <td><input type="text" name="order[]" value="{{ $point->point_order }}"></td>
                                        <td><input type="text" name="checkpoint_code[]" value="{{ $point->checkpoint_code }}"></td>
                                        <td><input type="text" name="lat[]" value="{{ $point->latitude }}"></td>
                                        <td><input type="text" name="long[]" value="{{ $point->longitude }}"></td>
                                        <td><input type="text" name="description[]" value="{{ $point->description }}"></td>
                                        <td><input type="text" name="beacon[]" value="{{ $point->beacon_id }}"></td>
                                        <td><a href="" class="delete">delete</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

          		</div>
          		
        	</div>