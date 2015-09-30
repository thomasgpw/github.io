<?php 
foreach ( new DirectoryIterator('./images/') as $Item ) :
if ($Item->isFile()) :
echo '<li><img src="BTCE/images/'. basename($Item). '" /></li>';
            endif;
        endforeach;
?>