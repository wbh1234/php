<?php
	echo"<table width=50 align=center border=1>";
		echo "<caption></caption>";
		for ($i=0; $i < 100; $i++) {
			echo "<tr>";
			for ($j=0; $j < 10; $j++) { 
				if($i%2==1){
				echo "<td bgcolor='red'>";
				}else{
					echo "<td bgcolor='green'>";
				}
				echo $i;
				echo"</td>";
			   }
		echo "</tr>";
		}
	echo "</table>";




?>