@extends('layouts.admin')
@section('content')
    <section id="basic-datatable">
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Equipment
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <form class="my-5" method="post" action="{{route('editEqType')}}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="first-name-icon">Device Type</label>

                                                <div class="position-relative has-icon-left">
                                                    <input type="text" class="form-control" value ={{ $eq->type }} name="type" placeholder="Device Type" >
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar "></i>
                                                    </div>
                                                </div>

                                            </div>
                                            <select class="select2 form-control" name="user"  required>
                                                <option value="" >select Employee</option>
                                                @foreach ($user as $list)
                                                    <option value="{{ $list->id }}"  @if( strcmp($list->first_name.' '.$list->last_name,$eq->employee)==0) selected  @endif >
                                                        {{ $list->first_name }} {{ $list->last_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="btn-group pull-right" style="margin-top:20px">
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
