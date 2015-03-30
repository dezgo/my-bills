<?php
// return TRUE if logged in, FALSE otherwise
function is_logged_in()
{
	if (isset($_SESSION['member_id']))
	{
		$member_id = $_SESSION['member_id'];		
	}
	else
	{
		$member_id = 0;
	}
	return $member_id != 0;
}

function boot_non_member()
{
	if (!is_logged_in()) redirect('Home');
}

function is_admin()
{
	if (isset($_SESSION['email_address']))
		return $_SESSION['email_address'] == 'mybills@derekgillett.com';
	else
		return FALSE;
}
