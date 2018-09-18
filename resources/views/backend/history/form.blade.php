            {{ csrf_field() }}  
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1"><small>Name</small></label>
                        <select name="guard_username">
                            @foreach( $guards as $guard)
                                @if(isset($post))
                                    <option value="{{ $guard->username }}" {{ $guard->username == $post->guard_username? 'selected="selected"':'' }}>{{ $guard->name }}</option>
                                @else
                                    <option value="{{ $guard->username }}">{{ $guard->name }}</option>
                                    @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><small>Cluster</small></label>
                        <select id="cluster" name="cluster" class="cluster form-control">
                            <option value="">== choice ==</option>
                            @foreach( $clusters as $cluster)
                                @if(isset($post))
                                    <option value="{{ $cluster->code }}" {{ $cluster->code == $post->getTrack->getCluster->code? 'selected="selected"':'' }}>{{ $cluster->name }}</option>
                                @else
                                    <option value="{{ $cluster->code }}">{{ $cluster->name }}</option>
                                    @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><small>Track</small></label>
                        <select id="track_code" name="track_code" class="track form-control">
                            @if(isset($post))
                            <option value="{{ $post->getTrack->code }}">{{ $post->getTrack->name }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group" id="datetimepicker" >
                        <label for="exampleInputPassword1"><small>Schedule Date</small></label>
                        <input name="date" value="{{ old('date',  isset($post->assign_date) ?substr($post->assign_date, 0, 10) : null) }}" type="text" class="form-control slug" placeholder="Schedule Date">
                    </div>
                    <div class="form-group" id='datetimepicker'>
                        <label for="exampleInputPassword1"><small>Shift</small></label>
                        <select name="shift_id" class="cluster form-control">
                            @foreach( $shifts as $shift)
                                @if(isset($post))
                                    <option value="{{ $shift->id }}" {{ $shift->id == $post->shift_id? 'selected="selected"':'' }}>{{ $shift->name }}</option>
                                @else
                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                    @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>