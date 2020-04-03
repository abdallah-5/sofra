@component('mail::message')
# Introduction

Sofra 

<p>
  Your code is : {{$code}}
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
