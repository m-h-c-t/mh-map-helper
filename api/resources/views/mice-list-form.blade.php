<!-- Mice list -->
<div class="container">
    <form method="GET" action="/search">
        <div class="form-group row">
            <h2><i class="glyphicon glyphicon-pencil"></i> Mice</h2>
        <textarea rows="10" class="form-control input-lg" name="mice" placeholder="Copy map mice list here..."
                  required maxlength="2000"
                @if( isset($micelist) && !empty($micelist) )>{{ $micelist }}@else autofocus="autofocus">@endif</textarea>
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-lg btn-primary col-sm-2 col-sm-offset-3">Search</button>
            <a class="btn btn-lg btn-danger col-sm-2 col-sm-offset-2" href="/">Reset</a>
        </div>
    </form>
</div>
