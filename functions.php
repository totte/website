<?php
function PrintContributor($image, $name, $alias, $email, $key,
						  $keylink, $website, $roles, $languages,
						  $country, $born)
{
	return "<div id='$alias'>"
	. "<img style='margin:auto;'
	width='120'
	height='148' class='img-rounded'
	src='static/img/contributors/" . $image . "' alt='" . $image . "' />"
	. "<h3
	 style='margin-top:0;'>$alias</h3>"
	. "Name:"
	. "$name"
	. "Email:"
	. "$email"
	. "PGP key:"
	. "<a href='$keylink'>$key</a>"
	. "Roles:"
	. $roles
	. "Website:"
	. "$website"
	. "Born:"
	. "$born"
	. "Country:"
	. "$country"
	. "Languages
	 :"
	. $languages
	. "</div>";
}

function PrintFormerContributor($image, $name, $alias, $email, $website)
{
	return "<div id='$alias'>"
	. "<img style='margin:auto;' width='120'
height='148' class='img-rounded'
src='static/img/contributors/" . $image . "' alt='" . $image . "' />"
	. "<h3 style='margin-top:0;'>$alias</h3>"
	. "Name:"
	. "$name"
	. "Email:"
	. "$email"
	. "Website:"
	. "$website"
	. "</div>";
}

?>
