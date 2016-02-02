@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-black" style="background: url('http://new.ppy.sh/images/headers/profile-covers/c1.jpg') center center;">
                    <h3 class="widget-user-username"><strong>{{ $user->name }}</strong></h3>
                    <h5 class="widget-user-desc">joined {{ date('F Y', strtotime($user->created_at)) }}</h5>
                </div>
                <div class="widget-user-image">
                    @if(Auth::user())
                        @if($user->id == Auth::user()->id)
                            <img class="img-circle" src="{{url("/".$user->id)}}" alt="User Avatar">
                            <a href="{{ url("/dashboard/avatar") }}" class="cornerLink">Edit</a>
                        @else
                            <img class="img-circle" src="{{url("/".$user->id)}}" alt="User Avatar">
                        @endif
                    @else
                        <img class="img-circle" src="{{url("/".$user->id)}}" alt="User Avatar">
                    @endif
                </div>
                <div class="box-footer">

                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">3,200</h5>
                                <span class="description-text">SALES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">13,000</h5>
                                <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">35</h5>
                                <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
    </section>
@endsection
