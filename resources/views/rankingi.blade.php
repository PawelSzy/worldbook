<!-- View (widok) zapisany w resources/views/kraj.blade.php -->

<html>
    <body>
        <h1>Wybierz Ranking</h1>

        {{ Form::open( array('method' => 'post', 'route' => array("ranking")  )) }}
		{{ Form::select('rankingi', $dane_rankingu) }}
		<br />
		{{ Form::submit('Pokaż') }}
        {{ Form::close() }}

    </body>
</html>