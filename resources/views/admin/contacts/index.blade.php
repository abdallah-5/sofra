@extends('admin.layouts.app')


@section('page_title')
  Contacts
@endsection

@section('content')



<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">List Of Contacts</h3>

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
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Type of message</th>
                <th>Delete</th>
              </tr>
            </thead>

            <tbody>
              @foreach($records as $record)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{optional($record)->name}}</td>
                  <td>{{optional($record)->email}}</td>
                  <td>{{optional($record)->phone}}</td>
                  <td>{{optional($record)->message}}</td>
                  <td>{{optional($record)->type_of_message}}</td>
                  <td class="text-center">
                    {!! Form::open([
                        'action' => ['Admin\ContactController@destroy',$record->id],
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
