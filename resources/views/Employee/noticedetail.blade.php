@extends('Employee.layouts.main')
@section('content')
    <?php
    use Carbon\Carbon;
    use App\Models\Attendence;
    use  App\Models\Notice;
    $notice=Notice::get();
    $todayDate = Carbon::now()->format('d-m-Y');

    ?>
        
   <div class="row ">
       

                            <div class="col-md-6">
                            <div class="card-deck-wrapper">
                                <div class="card-deck">
                                    <div class="card">
                                        <div class="card-content">
<div class="form-group">
                <label for="first-name-icon"  style="padding-top: 10px;"><h4> &nbsp;Title {{ $data->title }}</h4> </label> 
            </div>

   <div class="form-group">
                <label for="first-name-icon"> &nbsp;&nbsp;Description </label>
                <div class="position-relative has-icon-left" style="margin-left: 10px;">    {!! $data->description	!!}

                </div>

              
            </div>
             <div class="form-group">
                <label for="first-name-icon">&nbsp;&nbsp;Notice From Date <span>{{ $data->start_date }}</span></label>
              
            </div>  
            
            <div class="form-group">
                <label for="first-name-icon"> &nbsp;&nbsp;Notice To Date   <span> {{ $data->end_date }}</span></label>

              
            </div> 
        </div>
      
                                           

                                            
                                        </div>
                                    </div>

                                    
                                </div>
                        </div>
                    </div>

                  
  
                    
   </div>
       </div>

@endsection
