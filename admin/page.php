<?php
		$do='';

		if(isset($_GET['con'])){
			$do=$_GET['con'];
		}else{
			$do='mmmm';
		}
		echo $do;