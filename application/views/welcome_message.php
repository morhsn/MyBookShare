<div class="container clearfix">
    <div class="divcenter center clearfix" style="max-width: 900px;">
        <img class="bottommargin topmargin" src="images/logo.png" alt="MyBookSharing" data-animate="fadeInUp">
        <h1 data-animate="fadeInUp" data-delay="200">Welcome<?php if ($loggedIn): ?> Back <?php echo $username; ?>!</h1>
        <h1 data-animate="fadeInUp" data-delay="500"><?php else: ?>! <?php endif ?>This is <span>MyBookSharing</span>.
        </h1>
        <h2 class="capitailize" data-animate="fadeInUp" data-delay="1000">A platform for hard-copy book sharing among
            friends.</h2>
        <a href="page/FindBooks" class="button button-3d button-dark button-large" data-animate="fadeInLeft"
           data-delay="1400">Search For Books</a>
        <a href="page/Newsfeed" class="button button-3d button-large" data-animate="fadeInRight" data-delay="1400">Visit
            The News Feed</a>
    </div>

    <div class="clear"></div>

</div>