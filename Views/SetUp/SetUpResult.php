
<?php

function function_alert($message){
    echo("<script>
        alert(" . json_encode($message) . ");
        window.location.href='../LogIn/LogIn.php';
        </script>");
}

if(!empty($errors)){
    // print_r($errors);
    $mymessage = " ";
    foreach($errors as $error){               
        $mymessage .= $error;
        // echo $mymessage;
        $mymessage .= "\n"; 
        // echo $mymessage;
    };
    function_alert($mymessage);
}else{
    $massage = "The user was successfully created. Now you can Log In";
    function_alert($massage);
}
?>