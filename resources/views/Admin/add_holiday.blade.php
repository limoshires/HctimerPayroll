@extends('layouts.admin')
@section('content')

    <section id="basic-datatable">
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger ">    
                    <strong>{{ $message }}</strong>
                </div>
                @endif 
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Holidays</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <form class="my-5" method="post" action="{{url('admin/add_holiday_values')}}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="first-name-icon">Holiday Title</label>

                                                <div class="position-relative has-icon-left">
                                                    <input type="text" class="form-control" name="title" placeholder="title" >
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar "></i>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="password-icon">Holiday Date</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="date" id="password-icon" class="form-control"
                                                                name="date_" placeholder="date">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-money"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="btn-group pull-right">
                                                <button type="submit" class="btn btn-info pull-right">Submit</button>
                                            </div>


                                        </form>
                                        <br>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endsection
