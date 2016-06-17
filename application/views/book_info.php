<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <a href="https://books.google.co.il/books?id=<?php echo $book->google_id; ?>" target="_blank">
                <img
                    src="https://books.google.com/books?id=<?php echo $book->google_id; ?>&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api"
                    class="img-responsive">
            </a>
        </div>
        <div class="col-md-9">

            <div class="row">
                <?php if ($isOwnedByCurrentUser): ?>
                    <h3 class="capitalize">This book is in your bookshelf</h3>
                    <a href="/page/removebook/<?php echo $book->id; ?>" class="button button-primary button-3d">
                        <i class="icon-remove"></i> &nbsp;
                        Remove Book From My Bookshelf
                    </a>
                <?php else: ?>
                    <h3 class="capitalize">This book is not in your bookshelf</h3>
                    <a href="/page/addbook/<?php echo $book->google_id; ?>" class="button button-primary button-3d">
                        <i class="icon-line-marquee-plus"></i> &nbsp;
                        Add Book To My Bookshelf
                    </a>
                <?php endif ?>
            </div>

            <!----------------- Reviews ----------------------->
            <BR><BR>

            <h3>Reader Reviews</h3>
            <?php for ($i = 0; $i < count($reviews); $i++): ?>
                <H3>
                    <?php for ($j = 0; $j < $reviews[$i]->rating; $j++): ?>
                        <i class="icon-star3"></i>
                    <?php endfor; ?>
                </H3>
                <blockquote>
                    <?php echo $reviews[$i]->review_text; ?>
                    <footer><a
                            href="/page/bookshelf/<?php echo $reviews[$i]->id; ?>"><?php echo $reviews[$i]->name; ?></a>
                </blockquote>
                <BR><BR>
            <?php endfor; ?>

            <?php if (!$isReviewedByCurrentUser): ?>
                <a class="button button-primary button-lg button-3d" onclick="$('#review_form').show(); $(this).hide()"><i
                        class="icon-pencil"></i>&nbsp;Write A Review For This
                    Book
                </a>
            <?php endif; ?>

            <Form action="/page/reviewBook" method="post" id="review_form" style="display: none">
                <H3>Review :
                    <i class="icon-star-empty" onClick="rank(1)" id="rank1"></i>
                    <i class="icon-star-empty" onClick="rank(2)" id="rank2"></i>
                    <i class="icon-star-empty" onClick="rank(3)" id="rank3"></i>
                    <i class="icon-star-empty" onClick="rank(4)" id="rank4"></i>
                    <i class="icon-star-empty" onClick="rank(5)" id="rank5"></i>
                    <input type="hidden" name="rank" id="rank">
                    <input type="hidden" name="book" value="<?php echo $book->id; ?>">
                    <textarea name="review" rows="4" cols="80" style="vertical-align:bottom"></textarea>
                        <span>
                            <button type="submit" class="button button-primary button-sm button-3d">Send</button>
                        </span>
            </Form>

        </div>
    </div>
</div>

<Script>
    function rank(grade) {
        $('#rank').val(grade);
        for (i = 1; i <= grade; i++) {
            $('#rank' + i).removeClass('icon-star-empty');
            $('#rank' + i).addClass('icon-star3');
        }
        for (i = grade + 1; i <= 5; i++) {
            $('#rank' + i).removeClass('icon-star3');
            $('#rank' + i).addClass('icon-star-empty');
        }
    }
</Script>