Cart
    @if(\App\TempProductout::where('type',3)->count()->where('user_id',\Illuminate\Support\Facades\Auth::user()->id) != 0)
        <span class="badge badge-danger">{{\App\TempProductout::where('type',3)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->count()}}</span>
    @endif