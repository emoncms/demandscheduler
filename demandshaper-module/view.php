<?php 
/*

All Emoncms code is released under the GNU Affero General Public License.
See COPYRIGHT.txt and LICENSE.txt.

---------------------------------------------------------------------
Emoncms - open source energy visualisation
Part of the OpenEnergyMonitor project:
http://openenergymonitor.org

*/

global $path;

$device = "";
if (isset($_GET['node'])) $device = $_GET['node'];

$v=6;

?>

<script>
var path = "<?php echo $path; ?>";
var emoncmspath = "<?php echo $path; ?>remoteaccess/";
var device = "<?php echo $device; ?>";
var devices = {};

var apikeystr = "";
if (window.session!=undefined) {
    apikeystr = "&apikey="+session["apikey_write"];
}
</script>

<!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo $path;?>Lib/flot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.selection.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.touch.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.time.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Lib/flot/date.format.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path;?>Modules/vis/visualisations/common/vis.helper.js"></script>

<link rel="stylesheet" href="<?php echo $path; ?>Modules/demandshaper/demandshaper.css?v=<?php echo $v; ?>">
<link rel="stylesheet" href="<?php echo $path; ?>Lib/misc/sidebar.css?v=<?php echo $v; ?>">
<script type="text/javascript" src="<?php echo $path; ?>Modules/demandshaper/battery.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/misc/sidebar.js?v=<?php echo $v; ?>"></script>

<div id="wrapper">
  <!------------------------------------------------------------------------------------------------------>
  <div class="sidenav">
    <div class="sidenav-inner">
      <ul class="sidenav-menu"></ul>
    </div>
  </div>
  
  <script>
  init_sidebar({menu_element:"#demandshaper_menu"});
  $.ajax({ url: emoncmspath+"device/list.json", dataType: 'json', async: false, success: function(result) { 
      // Associative array of devices by nodeid
      devices = {};
      var out = "";
      for (var z in result) {
          if (result[z].type=="openevse" || result[z].type=="smartplug" || result[z].type=="hpmon") {
              devices[result[z].nodeid] = result[z];
              // sidebar list
              out += "<li><a href='"+path+"demandshaper?node="+result[z].nodeid+"'><span class='icon-"+result[z].type+"'></span>"+ucfirst(result[z].nodeid)+"</a></li>";
              // select first device if device is not defined
              if (device=="") device = result[z].nodeid;
          }
      }
      
      $(".sidenav-menu").html(out);
  }});

  function ucfirst(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
  }
  </script>
  <!------------------------------------------------------------------------------------------------------>
  
  <div id="scheduler-top"></div>
  <?php
      include "Modules/demandshaper/general.php";
  ?>
</div>



