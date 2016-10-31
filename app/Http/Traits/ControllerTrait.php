
<?
// Trait
trait ControllerTrait {
 
    /**
    * Polacz dwie kollekcje (collection) 
    *np.: kol1 = collect( (array("Polska", "Europa"), array("Niemcy", "Europa"); kol2 = collect(array("36 milionow", "dostep do morza"), array("84 miliony", "dostep do morza")
    * miks = zmiksujCollection(kol1, kol2)
    * miks->toArray(); zwroci [("Polska, Europa", "36 milionow", "dostep, do morza"), ("Niemcy", "Europa", "84 miliony", "dostep do morza")]
    * @param - collection, collection, string or number
    * @return - collection
    */
    public function zmiksujCollection($collection1, $collection2, $newKey = null) {    

        $array1 = $collection1->toArray(); 
        $array2 = $collection2->toArray();

        $zlaczonyArray = array_merge_recursive( $array1, $array2);



        if ($newKey == null) {
            return collect( $zlaczonyArray );
        } 
        else {
            $returnArray = array();

            foreach ($zlaczonyArray as $key => $value) {
                // $returnArray[ $value[ $newKey ] ] = $value;
                array_push($returnArray, $value );
            }

            $returnCollection = collect( $returnArray);
            $returnCollection = $returnCollection->keyBy( $newKey );

            return $returnCollection;

        }
    }
 
}