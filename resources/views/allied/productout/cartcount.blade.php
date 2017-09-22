Cart
    @if(\App\TempProductout::where('type',3)->count() != 0)
        <span class="badge badge-danger">{{\App\TempProductout::where('type',3)->count()}}</span>
    @endif