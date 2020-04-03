@extends('admin.layouts.app')


@section('page_title')
  Restaurants
@endsection

@section('content')



<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">List Of Restaurants</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>

      </div>
    </div>
    <div class="card-body">

      @include('flash::message')

      @if(count($records))

        <div class="table-responsive text-center">
          <table class="table table-bordered">

            <thead>
              <tr>
                <th>#</th>
                <th>Restaurant name</th>
                <th>Show</th>
                <th>Activate | DeActivate</th>
                <th>Delete</th>
              </tr>
            </thead>

            <tbody>
              @foreach($records as $record)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$record->name}}</td>
                  <td class="text-center">
                    <a href="{{url(route('restaurants.show',$record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-info"></i></a>
                  </td>
                  <td class="text-center">
                     @if($record->activate)
                         <a href="{{url(route('restaurants.deactivate',$record->id))}}"
                            class="btn btn-danger btn-xs">DeActivate</a>
                     @else
                         <a href="{{url(route('restaurants.activate',$record->id))}}"
                            class="btn btn-success btn-xs">Activate</a>
                     @endif
                 </td>
                  <td class="text-center">
                    {!! Form::open([
                        'action' => ['Admin\RestaurantController@destroy',$record->id],
                        'method' => 'delete'
                      ]) !!}
                      <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    {!! Form::close() !!}

                  </td>
                </tr>
              @endforeach
            </tbody>

          </table>

        </div>

      @else

        <div class="alert alert-success" role="alert">
          No data
        </div>

      @endif


    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->



@endsection
