<?php
		echo"九九乘法表";
		echo "<br>";
		for ($i=1; $i <= 9; $i++) { 
			for ($j=1; $j <= $i; $j++) { 
				echo $i."*". $j."=".($j*$i)."&nbsp";
			}
			echo "<br>";
		}
		

		echo "<table width=800 align=center border=1>";
		echo "<caption><h3>九九乘法表</h3></caption>";
	
			for ($i=1; $i <=9; $i++) {
					echo "<tr>";
			
				for ($j=1; $j <= $i; $j++) {
						echo "<td>";  
					echo $i."*".$j."=".($j*$i);
						echo "</td>";
				}
					echo "</tr>";
			
			}
		
		echo "</table>";
		echo "</br>";
		
		echo "<table width=800 align=center border=1>";
		echo "<caption><h3>九九乘法表</h3></caption>";
		for ($i=9; $i >=1; $i--) { 
			echo "<tr>";
			for ($j=1; $j < $i; $j++) { 
				echo "<td>";
				echo $i."*".$j."=".($i*$j);
				echo "</td>";
			}
			echo "<br />";
		}
		
		echo "<table width=800 align=center border=1>";
		echo "<caption><h3>九九乘法表</h3></caption>";
		for ($i=1; $i < 9; $i++) { 
			echo "<tr>";
			
			for ($j=1; $j < 9-$i; $j++) { 
				echo "<td>"."&nbsp;"."</td>";
			}
			for ($k=1; $k <= $i ; $k++) { 
				echo "<td>";
				echo $i. " * ".$k." = ".($i * $k );
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "</br>";
		
		echo "<table width=800 align=center border=1>";
		echo "<caption><h3>九九乘法表</h3></caption>";
		
		for ($i=9; $i >=1 ; $i--) { 
			echo "<tr>";
			
			for ($j=0; $j < 9-$i; $j++) { 
				echo "<td>"."&nbsp;"."</td>";
			}
			for ($k=1; $k <= $i; $k++) { 
				echo "<td>";
				echo $i."*".$k." = ".($i*$k);
				echo "</td>";
			}
				echo "</tr>";
		}
	echo "</table>";
		
	
	echo "<table width=800 align=center border=1>";
	echo "<caption><h3>九九乘法表</h3></caption>";
	
	for($i=9;$i>=1;$i--){
		echo "<tr>";
		//先打空格
		for($j=1;$j<=9-$i;$j++){
			echo "<td>"."&nbsp;"."</td>";
		}
		
		//再打算式
		for($k=1;$k<=$i;$k++){
			echo "<td>";
			echo $i." * ".$k." = ".($i*$k);
			echo "</td>";
		}
		
		echo "</tr>";
	}
	
	echo "</table>";
	
?>