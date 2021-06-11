<?php
	
	function fixPriceToBr(float $value): string
	{
		return number_format($value, 2,',','.');
	}