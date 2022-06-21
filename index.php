<?php



$str = file_get_contents('./review.json'); 

// -------- remove the utf-8 BOM ----
$str = str_replace("\xEF\xBB\xBF",'',$str); 

// -------- get the Object from JSON ---- 
$obj = json_decode($str, true);

// echo "<br><pre>";
// print_r($obj);


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $data = $_POST;



        foreach($obj as $object){
        

            if(($object['reviewText'] == "5 star review" || $object['reviewText'] == "4 star review" || $object['reviewText'] == "4 star review") && $object['rating'] >= 3){
                
                echo  $object['reviewText'] ." with text " ;
                
                // echo "<br><pre>";
                // print_r($object);
                if($data['date'] == 'oldest-first'){
            
                    echo $object['reviewCreatedOn'] = '- oldest first' . "<br>" ;
                } elseif($data['date'] == 'newest-first'){
                    echo $object['reviewCreatedOn'] = '- newest first' ."<br>" ;
                }

                echo  "<br><pre>" ;
                print_r($object);
            
            } elseif($object['reviewText'] == "" && $object['rating'] >= 3) {
                
                echo $object['rating'] .  $object['reviewText'] . " without text<br>" ;

                if($data['date'] == 'oldest-first'){
            
                    echo $object['reviewCreatedOn'] = '- oldest first' . "<br>" ;
                } elseif($data['date'] == 'newest-first'){
                    echo $object['reviewCreatedOn'] = '- newest first' ;
                }
                echo  "<br><pre>" ;
                print_r($object);
            }

       
            
        }

} else {
    header("Location: index.html");
}


// if( $object['reviewText'] == "5 star review" || $object['reviewText'] == "4 star review" || $object['reviewText'] == "4 star review"){
//     echo  $object['reviewText'] ." with text " ;
// } elseif($object['reviewText'] == ""){
//     echo  $object['reviewText'] . " without text<br>" ;
// }