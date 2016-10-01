<!-- View (widok) zapisany w resources/views/kraj.blade.php -->

<html>
    <body>
        <h1>Kraj View</h1>

        @foreach($kraj as $nazwa_kraju => $dane_kraju)
        	<h2> {{ $nazwa_kraju }} </h2>
		    @foreach ($dane_kraju as $key => $value) 
		    	<h3> {{$key}} </h3>
		        <p> {{$value}} </p>
		    @endforeach
        @endforeach


    </body>
</html>