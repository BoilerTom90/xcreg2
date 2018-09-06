<?php
?>
<script src="scripts/jquery-2.1.4.min.js"></script>
<script src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="table-sorter-master/jquery.tablesorter.min.js"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
    $(function(){$("#sortable-table").tablesorter();
    $('[data-toggle="tooltip"]').tooltip(); 
});
});
</script>
</body>
</html>