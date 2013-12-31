<?php
// ###############################################################
// ##                                                           ##
// ##   http://sites.google.com/site/pavelbaco/                 ##
// ##   Copyright (C) 2013  Pavel Bačo   (killerman)            ##
// ##   Copyright (C) 2013  kumeni@gmail.com (kumen)            ##
// ##                                                           ##
// ## This file is a part of xLiveCZ, this project doesnt have  ##
// ## any support from Xtreamer company and just be design for  ##
// ## realtek based players										##
// ###############################################################

$DIR_SCRIPT_ROOT  = current(explode('xLiveCZ/', dirname(__FILE__).'/')).'xLiveCZ/';
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
echo "<?xml version='1.0' encoding='utf-8' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

$query= $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = urlencode($queryArr[1]);
   $type = $queryArr[2];
   $ident = $queryArr[3];
}

if($type == "find")
{
	//set POST variables //what=test&category=&sort=&offset=0&limit=25&wst=
	$fields = array(
		'what' => $search,
		'category' => "video",
		'sort' => "",
		'offset' => $page * 25,
		'limit' => "25",
		'wst' => "",
		);

	$url = "http://webshare.cz/api/search/";
}else if($type == "watch")
{
	$fields = array(
		'ident' => $ident,
		'wst' => "",
		);

	$url = "http://webshare.cz/api/file_info/";
	$fields_string = "";
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
	//open connection
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-length: '.strlen($fields_string),'Content-Type: application/x-www-form-urlencoded','X-Requested-With: XMLHttpRequest','Host: webshare.cz'));
	curl_setopt($ch,CURLOPT_POST,count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	//execute post
	$info=curl_exec($ch);
	curl_close($ch);

	$fields = array(
		'ident' => $ident,
		'wst' => "",
		);

	$url = "http://webshare.cz/api/file_link/";
}

$fields_string = "";
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');
//open connection
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-length: '.strlen($fields_string),'Content-Type: application/x-www-form-urlencoded','X-Requested-With: XMLHttpRequest','Host: webshare.cz'));
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
//execute post
$result=curl_exec($ch);
curl_close($ch);

?>

<script>
	setRefreshTime(-1);
	enablenextplay = 0;
	itemCount = getPageInfo("itemCount");
	SwitchViewer(7);
</script>

<onRefresh>
	if ( Integer( 1 + getFocusItemIndex() ) != getPageInfo("itemCount") && enablenextplay == 1 && playvideo == getFocusItemIndex()) {
		ItemFocus = getFocusItemIndex();
		setFocusItemIndex( Integer( 1 + getFocusItemIndex() ) );
		redrawDisplay();
		setRefreshTime(-1);
		"true";
	}

	if ( enablenextplay == 1 ) {
		enablenextplay = 0;
		url=getItemInfo(getFocusItemIndex(),"paurl");
		movie=getUrl(url);
		playItemUrl(movie,10);

		if ( Integer( 1 + getFocusItemIndex() ) == getPageInfo("itemCount") ) {
			enablenextplay = 0;
			setRefreshTime(-1);
		} else {
			playvideo = getFocusItemIndex();
			setRefreshTime(4000);
			enablenextplay = 1;
		}
	} else {
		setRefreshTime(-1);
		redrawDisplay();
		"true";
	}
</onRefresh>

<mediaDisplay name="threePartsView"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"
	headerImageWidthPC="0"
	selectMenuOnRight="no"
	autoSelectMenu="no"
	autoSelectItem="no"
	itemImageHeightPC="0"
	itemImageWidthPC="0"
	itemXPC="3"
	itemYPC="25"
	itemWidthPC="52"
	itemHeightPC="8"
	capXPC="3"
	capYPC="25"
	capWidthPC="52"
	capHeightPC="64"
	itemBackgroundColor="0:0:0"
	itemPerPage="8"
    itemGap="0"
	bottomYPC="90"
	backgroundColor="0:0:0"
	showHeader="no"
	showDefaultInfo="no"
	imageFocus=""
	sliding="no" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10"
>

 <text align="center" offsetXPC="2" offsetYPC="3" widthPC="54" heightPC="19" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>
  	<text redraw="yes" offsetXPC="46" offsetYPC="15" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
	<text align="justify" redraw="yes"
          lines="9" fontSize=13
		      offsetXPC=58 offsetYPC=58 widthPC=40 heightPC=32
		      backgroundColor=0:0:0 foregroundColor=200:200:200>
			<script>print(annotation); annotation;</script>
		</text>
  	<text  redraw="yes" align="left" offsetXPC="58" offsetYPC="53" widthPC="13" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(durata); durata;</script>
		</text>
  	<text  redraw="yes" align="left" offsetXPC="72" offsetYPC="53" widthPC="26" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(pub); pub;</script>
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(titlu); titlu;</script>
		</text>
 <text align="center" offsetXPC="58.2" offsetYPC="0" widthPC="39.68" heightPC="52" fontSize="30" backgroundColor="130:130:130" foregroundColor="0:0:0">
		  <script>sprintf("webshare.cz",focus-(-1));</script>
		</text>
		<image  redraw="yes" offsetXPC=59 offsetYPC=1 widthPC=38 heightPC=50>
		<script>print(img); img;</script>
		</image>
			<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy1.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy2.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy3.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy4.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy5.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy6.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy7.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy8.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy9.png</idleImage>

		<itemDisplay>
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx)
					{
                      img = getItemInfo(idx,"image");
					  annotation = getItemInfo(idx, "annotation");
					  durata = getItemInfo(idx, "durata");
					  pub = getItemInfo(idx, "pub");
					  titlu = getItemInfo(idx, "title");
					}
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "14"; else "14";
  				</script>
				</fontSize>
			  <backgroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "10:80:120"; else "-1:-1:-1";
  				</script>
			  </backgroundColor>
			  <foregroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "255:255:255"; else "140:140:140";
  				</script>
			  </foregroundColor>
			</text>

		</itemDisplay>
<onUserInput>
			<script>
				ret = "false";
				userInput = currentUserInput();
				if (userInput == "PD" || userInput == "PG" || userInput == "pagedown" || userInput == "pageup") {
					idx = Integer(getFocusItemIndex());
					if (userInput == "PD" || userInput == "pagedown") {
						idx -= -10;
						if (idx &gt;= getPageInfo("itemCount"))
							idx = 0;
					} else {
						idx -= 10;
						if (idx &lt; 0)
							idx = getPageInfo("itemCount")-1;
					}
					print("new idx: "+idx);
					setFocusItemIndex(idx);
					setItemFocus(0);
					redrawDisplay();
					ret = "true";
				}
				ret;
</script>
</onUserInput>

	</mediaDisplay>
	<item_template>
		<mediaDisplay  name="threePartsView" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
        	<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy1.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy2.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy3.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy4.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy5.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy6.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy7.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy8.png</idleImage>
		<idleImage><?php echo $DIR_SCRIPT_ROOT; ?>image/busy9.png</idleImage>
		</mediaDisplay>

	</item_template>

<?php
if($type == "find")
{
	echo "<channel>\n<title>Vyhledáno</title>";
	if($page > 0)
	{
		?>
			<item>
		<?php
			$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
			$url = $sThisFile."?query=".($page-1).",".$search.",find,";
		?>
			<title>Předchozí strana</title>
			<link><?php echo $url;?></link>
			<annotation>Předchozí strana</annotation>
			<durata></durata>
			<pub></pub>
			<image><?php echo $DIR_SCRIPT_ROOT; ?>image/leva.jpg</image>
			<mediaDisplay name="threePartsView"/>
		</item>
		<?php
	}

	$t1 = explode('<status>', $result);
	$t2 = explode('</status>', $t1[1]);
	$status = $t2[0];

	if($status == "OK")
	{
		$files = explode('<file>', $result);
		unset($files[0]);

		foreach($files as $file)
		{
			$t1 = explode('<ident>', $file);
			$t2 = explode('</ident>', $t1[1]);
			$ident = $t2[0];

			$t1 = explode('<name>', $file);
			$t2 = explode('</name>', $t1[1]);
			$name = $t2[0];

			$t1 = explode('<type>', $file);
			$t2 = explode('</type>', $t1[1]);
			$type = $t2[0];

			$t1 = explode('<img>', $file);
			$t2 = explode('</img>', $t1[1]);
			$img = "http://webshare.cz".$t2[0];

			$t1 = explode('<size>', $file);
			$t2 = explode('</size>', $t1[1]);
			$size = $t2[0] / 1024 / 1024;
			$size .= "MB";

			echo "
				<item>
					<title><![CDATA[".$name."]]></title>
					<image>".$img."</image>
					<pub>Velikost: ".$size."</pub>
					<durata>Formát: ".$type."</durata>
					<link>".$HTTP_SCRIPT_ROOT."xLiveCZ/webshare.php?query=0,nic,watch,".$ident."</link>
				</item>\n";
		}

	?>
	<item>
	<?php
	$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	$url = $sThisFile."?query=".($page+1).",".$search.",find,";
	?>
	<title>Další strana</title>
	<link><?php echo $url;?></link>
	<annotation>Další strana</annotation>
	<durata></durata>
	<pub></pub>
	<image><?php echo $DIR_SCRIPT_ROOT; ?>image/prava.jpg</image>
	<mediaDisplay name="threePartsView"/>
	</item>

	<?php
	}else
	{
		echo "<item>
				<title><![CDATA[Někde nastala chyba]]></title>
				<image></image>
				<pub></pub>
				<link></link>
			</item>\n";
	}
}else if($type == "watch")
{
	echo "<channel>\n<title>Webshare.cz</title>";

	$t1 = explode('<status>', $result);
	$t2 = explode('</status>', $t1[1]);
	$status = $t2[0];

	$t1 = explode('<status>', $info);
	$t2 = explode('</status>', $t1[1]);
	$status_2 = $t2[0];

	if($status == "OK" && $status_2 == "OK")
	{
		$t1 = explode('<link>', $result);
		$t2 = explode('</link>', $t1[1]);
		$link = $t2[0];

		$t1 = explode('<name>', $info);
		$t2 = explode('</name>', $t1[1]);
		$name = $t2[0];

		$t1 = explode('<stripe>', $info);
		$t2 = explode('L.jpg</stripe>', $t1[1]);
		$img = "http://webshare.cz/".$t2[0]."S.jpg";

		$t1 = explode('<format>', $info);
		$t2 = explode('</format>', $t1[1]);
		$format = $t2[0];

		$t1 = explode('<height>', $info);
		$t2 = explode('</height>', $t1[1]);
		$height = $t2[0];

		$t1 = explode('<width>', $info);
		$t2 = explode('</width>', $t1[1]);
		$width = $t2[0];

		$t1 = explode('<length>', $info);
		$t2 = explode('</length>', $t1[1]);
		$lenght = $t2[0]/60;

		$t1 = explode('<fps>', $info);
		$t2 = explode('</fps>', $t1[1]);
		$fps = $t2[0];


		echo "<item>
				<title>PLAY: ".$name."</title>
				<link>".$link."</link>
				<image>".$img."</image>
				<pub>".$format.": ".$width."x".$height." ".$fps."FPS</pub>
				<durata>".$lenght."min</durata>
				<enclosure type=\"video/mp4\" url=\"".$link."\"/>
			</item>\n";

	}else
	{
		echo "<item>
				<title>Někde nastala chyba></title>
				<image></image>
				<pub></pub>
				<link></link>
			</item>\n";
	}
}
	echo "</channel>\n</rss>";
?>
