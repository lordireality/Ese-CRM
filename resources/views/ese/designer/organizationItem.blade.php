@extends('ese.designer.index')

@section('pagename', 'Штатное расписание - ESE-CRM Dev. Studio')
@section('devStudioSectionName', 'Штатное расписание - ')
@section('DevStudioContent')
<iframe class="iframeSilent" src="{{route('BuildTree')}}" ></iframe>
<!--@foreach($organizationItems as $orgItem)
{{$orgItem->name}}
@endforeach-->


<script>

</script>
@endsection