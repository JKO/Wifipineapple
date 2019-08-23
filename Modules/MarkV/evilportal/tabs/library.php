<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include "../functions.php";

?>

<h2>Saved Portals</h2>
<hr />

<br />

<div id="evilportalLibrary">
<?php

  showSavedPortals();

?>
</div>