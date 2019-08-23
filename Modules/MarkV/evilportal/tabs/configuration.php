
<form method="POST" id="show_nodogsplash" action="/components/infusions/evilportal/includes/requests.php?configfile=/etc/nodogsplash/nodogsplash.conf"></form>
<form method="POST" id="configure_evilportal" action="/components/infusions/evilportal/includes/requests.php?configure=large"></form>

<h2>Manually Configure EvilPortal</h2>
<p>Click <a href="#" onclick="evilportalConfigure('#configure_evilportal', 'large');"><i>here</i></a> to auto configure Evil Portal!</p>
<hr />

<ul>
  <br />
  <li><b>Configure NoDogSplash</b> <a href="#" onclick="evilportalAjaxPopup('#show_nodogsplash');">[Show Config]</a></li>
  <br />
  <ul>
    <li>Click "<i>Show Config</i>" above to modify the configuration file.</li>
    <li>Look for the line that says "<i>FirewallRuleSet preauthenticated-users {</i>".</li>
    <li>Under that you should see "<i>#    FirewallRule allow tcp port 80 to 123.321.123.321</i>" remove the "<i>#</i>" and replace "<i>123.321.123.321</i>" with "<i>172.16.42.1</i>".</li>
    <li>Look for the line that says "<i>FirewallRuleSet users-to-router {</i>" and under that look for: "<i>FirewallRule allow tcp port 443</i>".</li>
    <li>Below this you need to add: "<i>FirewallRule allow tcp port 1471</i>".</li>
    <li>If you have change the management port from "<i>1471</i>" to something else you will need to replace "<i>1471</i>" above with your port.</li>
    <li>Look for <i>"# GatewayPort 2050"</i>. Remove the <i>"#"</i> at the begning then save the changes.</li>
  </ul>

  <br />

  <li><b>Finalize Configuration</b></li>
  <br />
  <ul>
    <li>Click <i>"Finalize Configuration"</i> below when are you all done.</li>
    <li>This will tell Evil Portal you are ready to move on.</li>
  </ul>
</ul>

<center>
  <button href="#" onclick="notify('Evil Portal is now ready for use!'); evilportalRefreshTile('large');">Finalize Configuration</button>
</center>