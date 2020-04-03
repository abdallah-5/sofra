<div class="form-group">
  <label for="name">About us</label>
  {!! Form::text('about_us',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="name">Fb link</label>
  {!! Form::text('fb_link',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="name">Inst link</label>
  {!! Form::text('inst_link',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="name">Tw link</label>
  {!! Form::text('tw_link',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="name">Commission</label>
  {!! Form::text('commission',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="name">Bank account</label>
  {!! Form::text('bank_account',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <label for="commission_text">Commission text</label>
  {!! Form::textarea('commission_text',null,[
    'class' => 'form-control'
  ]) !!}

</div>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
