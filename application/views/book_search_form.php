<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container clearfix">

    <div class="row">
        <form action="/page/searchBook" method="post" name="searchForm" id="searchForm" onsubmit="return validate();">
            <div class="col-md-8 center">
                <input type="text"
                    <?php if (!empty($searchTerm)) {
                        echo "value = \"" . htmlspecialchars($searchTerm) . "\"";
                    } else {
                        echo "placeholder = 'Your Search Term Goes Here'";
                    } ?>

                       name="searchTerm" id="searchTerm" class="sm-form-control text-center">
                <input type="hidden" name="pageNumber" id="pageNumber" value="1">
            </div>
            <div class="col-md-4 center">
                <a onclick="validate() && document.getElementById('searchForm').submit();"
                   class="button button-3d button-rounded button-blue" style="width: 60%; margin: 0;"><i
                        class="icon-search3"></i>Search</a>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        function validate() {
            var searchTermInput = document.getElementById('searchTerm');
            if (searchTermInput.value != '') {
                return true;
            }
            else {
                searchTermInput.style.border = '2px solid #ff0000';
                searchTermInput.placeholder = "Search Term Can't Be Empty";
                searchTermInput.focus();
                return false;
            }
        }
    </script>
</div>

</div> <!-- Closed for div in a different view -->

</section><!-- #content end --> <!-- Closed for section in a different view -->