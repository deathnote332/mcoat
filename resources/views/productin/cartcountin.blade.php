Cart
@if(\App\TempProductout::where('type',2)->count() != 0)
    <span class="badge badge-danger">{{\App\TempProductout::where('type',2)->count()}}</span>
@endif