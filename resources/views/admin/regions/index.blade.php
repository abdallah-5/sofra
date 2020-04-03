@extends('admin.layouts.app')


@section('page_title')
  Regions
@endsection

@section('content')



<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">List Of Regions</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>

      </div>
    </div>
    <div class="card-body">
      <div class="">
        <a href="{{url(route('regions.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Region</a>
      </div>
      <br>
      @include('flash::message')

      @if(count($records))

        <div class="table-responsive text-center">
          <table class="table table-bordered">

            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>City name</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>

            <tbody>
              @foreach($records as $record)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$record->name}}</td>
                  <td>{{optional($record->city)->name}}</td>
                  <td>
                    <a href="{{url(route('regions.edit',$record->id))}}" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
                  </td>
                  <td class="text-center">
                    {!! Form::open([
                        'action' => ['Admin\RegionController@destroy',$record->id],
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
