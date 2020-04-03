@inject('perm', 'App\Models\Permission')

<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="display_name">Display name</label>
  {!! Form::text('display_name',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="description">Description</label>
  {!! Form::text('description',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label>Permissions</label>
  <br>
  <input id="selectAll" type="checkbox"><label for='selectAll'>Select All</label>
  <div class="row">
    @foreach ($perm->all() as $permission)
      <div class="col-sm-3">
        <div class="checkbox">
          <label>
              <input type="checkbox" name = "permissions_list[]" value="{{$permission->id}}"

                    @if ($model->hasPermission($permission->name))
                        checked
                    @endif
                    >
                    {{$permission->display_name}}
          </label>

        </div>

      </div>
    @endforeach

  </div>

</div>


<div class="form-group">
  <button type="submit" class="btn btn-primary">Submit</button>
</div>


@push('scripts')
      <script>
      $("#selectAll").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
      });

      </script>
@endpush
