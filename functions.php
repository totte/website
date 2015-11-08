<?php
function PrintContributor($image, $name, $alias, $email, $key,
						  $keylink, $website, $roles, $languages,
						  $country, $born)
{
	return "<div id='$alias'>"
	. "<img style='margin:auto;' width='120' height='148' class='img-rounded' src='static/img/contributors/" . $image . "' alt='" . $image . "' />"
	. "<h3 style='margin-top:0;'>$alias</h3>"
	. "<dl class='dl-horizontal'>"
	. "<dt>Name</dt>"
	. "<dl>$name</dl>"
	. "<dt>E-mail</dt>"
	. "<dl>$email</dl>"
	. "<dt>PGP key</dt>"
	. "<dl><a href='$keylink'>$key</a></dl>"
	. "<dt>Roles</dt>"
	. "<dl>$roles</dl>"
	. "<dt>Website</dt>"
	. "<dl>$website</dl>"
	. "<dt>Born</dt>"
	. "<dl>$born</dl>"
	. "<dt>Country</dt>"
	. "<dl>$country</dl>"
	. "<dt>Languages</dt>"
	. "<dl>$languages</dl>"
	. "</dl>"
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
