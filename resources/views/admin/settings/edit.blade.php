@extends('admin.layouts.app')


@section('page_title')
  Edit Setting
@endsection

@section('content')



<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Setting</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>

      </div>
    </div>
    <div class="card-body">

      @include('admin.partials.validation_errors')

      {!! Form::model($model, [
        'action' => ['Admin\SettingController@update',$model->id],
        'method' => 'put'
        ]) !!}

        @include('flash::message')
        @include('admin.settings.form')



      {!! Form::close() !!}


    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->



@endsection
