@extends('admin.layouts.app')

@section('page_title')
  Order details
@endsection

@section('content')


<!-- Main content -->

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Order details</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      @include('flash::message')
        <div class="table-responsive">
          <table class="table table-bordered">

            <tr>
              <th class="text-center" width="40%">Client name</th>
              <td class="text-center">{{optional($model->client)->name}}</td>
            </tr>

            <tr>
              <th class="text-center" width="40%">Restaurant name</th>
              <td class="text-center">{{optional($model->restaurant)->name}}</td>
            </tr>

            <tr>
              <th class="text-center" >Status</th>
              <td class="text-center">{{$model->status}}</td>
            </tr>
            <tr>
              <th class="text-center">Payment method</th>
              <td class="text-center">{{optional($model->paymentMethod)->name}}</td>
            </tr>
            <tr>
              <th class="text-center">Cost</th>
              <td class="text-center">{{optional($model)->cost}}</td>
            </tr>
            <tr>
              <th class="text-center">Delivery cost</th>
              <td class="text-center">{{optional($model)->delivery_cost}}</td>
            </tr>

            <tr>
              <th class="text-center">Total</th>
              <td class="text-center">{{$model->total}}</td>
            </tr>

            <tr>
              <th class="text-center">Commission</th>
              <td class="text-center">{{$model->commission}}</td>
            </tr>

            <tr>
              <th class="text-center">Address</th>
              <td class="text-center">{{$model->address}}</td>
            </tr>

            <tr>
              <th class="text-center">Special order</th>
              <td class="text-center">{{$model->special_order}}</td>
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
