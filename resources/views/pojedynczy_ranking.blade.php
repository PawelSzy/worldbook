<!-- View (widok) zapisany w resources/views/kraj.blade.php -->

<html>
    <body>



        @forelse($ranking as $nazwa_rankingu => $dane_rankingu)
        	<h2> {{ $nazwa_rankingu }} </h2>
        	<ul>
		    @foreach ($dane_rankingu as $key => $value) 
		    	<li>
		    		{{$key}} : {{$value}}
		    	</li>		
		    @endforeach
		</ul>
		@empty
			<p>Nie znaleziono kraju o takiej nazwie</p>
        @endforelse


    </body>
</html>