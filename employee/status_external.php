<?php
require_once('../global/connect.php');
require_once('../global/functions.php');
?>

<html>

<head>
  <title>Check status</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Online portal for quarter allotment" />
  <meta name="keywords" content="CCL Ranchi, Central Coalfields Limited, CCL Quarter Allotment" />
  <meta name="author" content="Ayush Lal, Gobind Manuja"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/employee.css" />
  <link rel="icon" href="../images/logo.gif" type="image/gif" sizes="16x16">
  <script type="text/javascript" src="scripts/functions.js"></script>
</head>

<body>

	<?php include_once('../global/header.php');?>

	<div id="navbar">

		<ul>
			<li><a href="../index.php">Home</a></li>
			<li><a href="http://www.centralcoalfields.in" target="_blank"> About Us </a></li>
			<li><a href="../downloads/Sample.pdf" target="_blank">Notice</a></li>
			<li><a href="register.php">Register</a></li>
			<li><a href="login.php">Login</a></li>
			<li><a class="active" href="status_external.php">Check Status</a></li>
		</ul>

	</div>

	<div id="contents">

    <h1>Check your application status here</h1>

    <form class="form">
      <table>
      <tr>
        <td><input type="text" id="emp_pis" placeholder="PIS Number"></td>
        <td><button type="button" onclick="applicationLookupMinimal('emp_pis')">Search</button>
        <td><button type="reset">Reset</button>
      </tr>
      </table>
    </form>
    <form class="form">
      <table>
      <tr>
        <td><input type="text" placeholder="Reference Number" id="app_refNo"></td>
        <td><button type="button" onclick="applicationLookupMinimal('app_refNo')">Search</button>
        <td><button type="reset">Reset</button>
      </tr>
      </table>
    </form>

    <div id="searchResult"></div>

	</div>

   <?php include_once('../global/footer.php');?>

</body>

</html>
