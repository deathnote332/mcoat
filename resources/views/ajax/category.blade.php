@foreach( $data as $key=>$val)
    <option value="{{ $val->category }}">{{ $val->category }}</option>
@endforeach