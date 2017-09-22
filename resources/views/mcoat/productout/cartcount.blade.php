Cart
    @if(\App\TempProductout::where('type',1)->count() != 0)
        <span class="badge badge-danger">{{\App\TempProductout::where('type',1)->count()}}</span>
    @endif