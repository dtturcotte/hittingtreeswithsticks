<?php include 'include/header.php'; ?>

<center>

<h2>Admin Login</h2>
<br/>

<form action="?action=login" method="post">
	<table>
		<tr>
			<td>Username: </td><td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Password: </td> <td><input type="text" name="pw"></td>
		</tr>
	</table>
	<br />
	<input type="submit" value="Log in">
</center>

<?php include 'include/footer.php'; ?>
