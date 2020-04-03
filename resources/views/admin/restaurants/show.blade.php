@extends('admin.layouts.app')

@section('page_title')
  Restaurant details
@endsection

@section('content')


<!-- Main content -->

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Restaurant details</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body">
      @include('flash::message')
        <div class="table-responsive">
          <table class="table table-bordered">

            <tr>
              <th class="text-center" width="40%">Name</th>
              <td class="text-center">{{$model->name}}</td>
            </tr>

            <tr>
              <th class="text-center" width="40%">Email</th>
              <td class="text-center">{{$model->email}}</td>
            </tr>

            <tr>
              <th class="text-center" >Phone</th>
              <td class="text-center">{{$model->phone}}</td>
            </tr>
            <tr>
              <th class="text-center">Whatsapp</th>
              <td class="text-center">{{$model->whatsapp}}</td>
            </tr>
            <tr>
              <th class="text-center">Region</th>
              <td class="text-center">{{optional($model->region)->name}}</td>
            </tr>
            <tr>
              <th class="text-center">Image</th>
              <td class="text-center">{{optional($model->region)->image}}</td>
            </tr>

            <tr>
              <th class="text-center">Minimum order</th>
              <td class="text-center">{{$model->minimum_order}}</td>
            </tr>

            <tr>
              <th class="text-center">Delivery charge</th>
              <td class="text-center">{{$model->delivery_charge}}</td>
            </tr>

            <tr>
              <th class="text-center">Available</th>
              <td class="text-center">{{$model->available}}</td>
            </tr>

            <tr>
              <th class="text-center">Created at</th>
              <td class="text-center">{{$model->created_at}}</td>
            </tr>

            <tr>
              <th class="text-center">Contact phone</th>
              <td class="text-center">{{$model->contact_phone}}</td>
            </tr>

          </table>

        </div>


    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->


@endsection
