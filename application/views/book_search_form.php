<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container clearfix">

    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-9">
            <form action="/page/searchBook" method="post" name="searchForm">
                Find Book:<BR>
                <input type="text" name="searchTerm">
                <button type="submit" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-plus"></span> Search
                </button>
            </form>
        </div>
    </div>

</div>

</div> <!-- Closed for div in a different view -->

</section><!-- #content end --> <!-- Closed for section in a different view -->