<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header"><h1> News Feed </h1>
            </div> <?php for ($i = 0; $i < count($result); $i++): ?>
                <div class="row">
                    <div class="panel panel-default newsFeedWrapper">
                        <div class="panel-heading">
                            <h4><a href="/page/bookshelf/<?php echo $result[$i]->friend_id; ?>">
                                    <Img border="0"
                                         src="https://graph.facebook.com/<?php echo $result[$i]->friend_fbid; ?>/picture?width=40&height=40"
                                         width="40" height="40" class="img-rounded"> </a>
                                &nbsp; <?php echo htmlspecialchars($result[$i]->friend_name) . ' added a book to his/her bookshelf.'; ?>
                            </h4></div>
                        <div class="panel-body text-center">
                            <Img class="img-rounded newsFeedImg"
                                 src="https://books.google.com/books?id=<?php echo $result[$i]->google_id; ?>&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api"
                                 style="min-height:180px;height:180px;">

                            <div class="btn-group newsFeedBookMenu">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span
                                        class="caret"></span></button>
                                <ul class="dropdown-menu pull-right nopadding">
                                    <li>
                                        <form class="nobottommargin" action="page/loanBook" method="post"
                                              name="loanFormNum<?php echo $i; ?>">
                                            <input type="hidden" value="<?php echo $result[$i]->google_id; ?>"
                                                   name="bookGoogleId">
                                            <input type="hidden" value="<?php echo $result[$i]->friend_id; ?>"
                                                   name="ownerUserId">
                                            <button type="submit" style="width: 100%;"
                                                    class="button button-primary button-sm nomargin">
                                                <i class="icon-line2-star"></i>&nbsp;Request Loan
                                            </button>
                                        </form>
                                    </li>
                                    <li><a class="button button-primary nomargin"
                                           href="page/book/<?php echo $result[$i]->book_id; ?>"><i
                                                class="icon-line2-info"></i>&nbsp;Book's Profile</a></li>
                                </ul>
                            </div>
                            <div class="newsFeedBookInfo">
                                <h4><?php echo htmlspecialchars($result[$i]->book_name); ?></h4>
                                <h6><?php echo htmlspecialchars($result[$i]->book_author); ?></h6></div>
                        </div>
                        <div class="panel-footer text-center"><p>Added
                                at: <?php echo $result[$i]->book_added_date; ?></p></div>
                    </div>
                </div>            <?php endfor; ?>        </div>
    </div>
</div>