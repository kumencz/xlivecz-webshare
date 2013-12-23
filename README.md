xLiveCZ - Webshare
==============

Extension for xLiveCZ multimedia project for czech and slovak users for mediaplyers with realtek chip

Big thanks to killerman !!!

Rest of project:

http://code.google.com/p/xlivecz/

https://sites.google.com/site/pavelbaco/

Install:
==============


In file /scripts/xLiveCZ/category/rss/nezarazene.php<br />
V souboru /scripts/xLiveCZ/category/rss/nezarazene.php

after:<br />
po:

```xml
<channel>
   <title>Nezařazené</title>
   <link>/channel/nezarazene-2/rss</link>
```

add these lines:<br />
vložte tyto řádky:

```xml
<item>
   <title>Webshare.cz</title>
   <link>rss_command://search</link>
   <search url="<?php echo $HTTP_SCRIPT_ROOT; ?>xLiveCZ/webshare.php?query=0,%s,find," />
   <media:thumbnail url="http://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash2/s160x160/399064_402078543214882_2126773752_a.png"/>
</item>
```

Insert webshare.php file into /scripts/xLiveCZ/ directory<br />
Vložte soubor webshare.php do složky /scripts/xLiveCZ/

-> Instalation COMPLETE

Watch on yours custom videos uploaded to webshare.cz on your Xtreamer with xLiveCZ installed!<br />
Záměrem bylo Vám zpřístupnit Vámi nahráná rodiná videa na serveru webshare.cz, a umožit Vám tak sledování rodinných či jinných zažitků na jakémkoliv Xtreameru s xLiveCZ!
