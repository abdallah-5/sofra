


<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name',null,[
    'class' => 'form-control'
  ]) !!}

</div>

@inject('cities','App\Models\City')
{!! Form::Label('city', 'City:') !!}
{!! Form::select('city_id', $cities->pluck('name','id')->toArray(), null , ['class' => 'form-control']) !!}
<br>
<div class="form-group">
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
