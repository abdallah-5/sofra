@extends('admin.layouts.app')


@section('page_title')
  Orders
@endsection

@section('content')



<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">List Of Orders</h3>

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
                <th>Client name</th>
                <th>Restaurant name</th>
                <th>Total</th>
                <th>Show</th>
                <th>Print</th>
              </tr>
            </thead>

            <tbody>
              @foreach($records as $record)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{optional($record->client)->name}}</td>
                  <td>{{optional($record->restaurant)->name}}</td>
                  <td>{{optional($record)->total}}</td>
                  <td class="text-center">
                    <a href="{{url(route('orders.show',$record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-info"></i></a>
                  </td>
                  <td></td>
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
