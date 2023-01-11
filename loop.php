<?php

echo $_SERVER['DOCUMENT_ROOT']; // this will enable you to see 
                                // the correct path to your website dir 
                                // which should be written in .htaccess 
                                // instead of correct_path_to_your_website
                                // (check it just in case)

$foo = $bar['nope'];// this should generate notice 

call_undefined(); // this should generate fatal error


?>