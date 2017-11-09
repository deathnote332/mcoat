{{ \App\TempProductout::where('type',2)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->count() }}
