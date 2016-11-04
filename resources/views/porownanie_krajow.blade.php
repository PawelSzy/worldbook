<!-- View (widok) zapisany w resources/views/kraj.blade.php -->

<html>
    <body>

    	<table>
		  <tr>
		  	<th> Porównywana wartość</th>
		    <th>{{ $daneKrajow["nazwaKrajow"][0] }}</th>
		    <th>{{ $daneKrajow["nazwaKrajow"][1] }}</th>
		  </tr>	
		  <tr>
			 @forelse($daneKrajow["dane"] as $nazwaAtrybutu => $dane_atrybuty)
				<tr>
					<td> {{ $nazwaAtrybutu}} </td>	
					<td> {{ $dane_atrybuty[0]}} </td>
					<td> {{$dane_atrybuty[1]}} </td>			
				</tr>
			@empty
				<p>Nie znaleziono danych</p>
	        @endforelse
		  </tr>
		</table>
    </body>
</html>