xLiveCZ - Webshare
==============

Part of xLiveCZ multimedia project for czech and slovak users for mediaplyers with realtek chip

Big thanks to killerman !!!

Rest of project:

http://code.google.com/p/xlivecz/

https://sites.google.com/site/pavelbaco/

Install:
==============


In file xLiveCZ/category/rss/nezarazene.php after:

```php
<channel>
	<title>Nezařazené</title>
	<link>/channel/nezarazene-2/rss</link>
```

add these lines:

```php
<item>
   <title>Webshare.cz</title>
   <link>rss_command://search</link>
   <search url="<?php echo $HTTP_SCRIPT_ROOT; ?>xLiveCZ/webshare.php?query=0,%s,find" />
   <media:thumbnail url="http://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash2/s160x160/399064_402078543214882_2126773752_a.png"/>
</item>
```
