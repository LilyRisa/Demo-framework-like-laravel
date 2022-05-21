
@extends('layout')

@section('content')
<div class="sss">
    <form action="@route({"name": "test", "id": 3, "c_id" : 4})" method="post">
        @csrf_field()
        <input type="text" class="formr-control" name="bvminh" value="" />
        <input type="submit" value="submit">
    </form>
</div>

@endsection

@section('script')

@endsection