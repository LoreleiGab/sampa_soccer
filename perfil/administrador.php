<?php
	if(isset($_GET['p']))
    {
        $p = $_GET['p'];
    }
    else
    {
        $p = "index";
    }
	include "adm/".$p.".php";