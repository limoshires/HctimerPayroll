@extends('Employee.layouts.main')
@section('content')
    <?php
    use Carbon\Carbon;
    use App\Models\Attendence;
    use  App\Models\Notice;
    $notice=Notice::select('id','title','end_date')->get();
    $todayDate = Carbon::now()->format('d-m-Y');

    ?>
        
   <div class="row">
       @foreach($notice as $data)
       @php 
               $total_time_seconds = Carbon::parse($data->start_time)->diffInDays($data->end_date);
               $total_time_seconds = Carbon::parse($data->start_time)->diffInDays($todayDate);
       @endphp
           @if($data->start_date<=$data->end_date)

                            <div class="col-md-3">
                            <div class="card-deck-wrapper">
                                <div class="card-deck">
                                    <div class="card">
                                        <div class="card-content">

                                            <div class="card-body">
                                                <h4 class="card-title">{{ $data->title }}</h4>
                                                {{--  <p class="card-text">This card has supporting text below as a natural lead-in to
                                                    additional content.</p>  --}}
                                                <p class="card-text"><small class="text-muted">Expridate {{ $data->end_date }}</small>   
<a class="btn btn-primary btn-sm  float-right  " href="{{ route('employee.notices.details',$data->id) }} "  style="font-size: 15px;">show</a>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    @else

                    @endif
 @endforeach
   </div>
       </div>

@endsection
