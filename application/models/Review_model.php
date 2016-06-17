<?php

/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 13/06/14
 * Time: 21:23
 */
class review_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function addReview($userId, $bookId, $rank, $review)
    {
        $row = array(
            "user_id" => $userId,
            "book_id" => $bookId,
            "rating" => $rank,
            "review_text" => $review
        );
        $this->db->insert('review', $row);
    }

    function getReviews($bookId)
    {
        if ($bookId == null)
            return null;
        $queryStr = 'SELECT * FROM review R NATURAL JOIN user U WHERE R.user_id=U.id AND book_id=' . $bookId . ';';
        $query = $this->db->query($queryStr);
        return $query->result();
    }

    function isReviewedBy($bookId, $userId)
    {
        $reviews = $this->db->query('SELECT * FROM review WHERE user_id="' . $userId . '" AND book_id="' . $bookId . '"')->result();
        return (count($reviews) > 0);
    }

    function getMassReviews($books)
    {
        for ($i = 0; $i < count($books); $i++) {
            if ($books[$i] != null && !is_integer($books[$i]) && array_key_exists('id', $books[$i])) { // Book is not null and is in the local DB already
                if (is_object($books[$i]))
                    $queryStr = 'SELECT * FROM review R NATURAL JOIN user U WHERE R.user_id=U.id AND book_id=' . $books[$i]->id . ';';
                else
                    $queryStr = 'SELECT * FROM review R NATURAL JOIN user U WHERE R.user_id=U.id AND book_id=' . $books[$i]['id'] . ';';
                $query = $this->db->query($queryStr);
                if (!empty($query->result())) {
                    if (is_object($books[$i]))
                        $books[$i]->reviews = $query->result();
                    else
                        $books[$i]['reviews'] = $query->result();
                }
            }
        }
        return $books;

    }
} 