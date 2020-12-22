<?php

namespace App\Views\Tables\Feedback;

use App\Views\Table;

class FeedbackTable extends Table
{
    public function __construct($comments = [])
    {
        parent::__construct([
            'headers' => [
                'Name',
                'Comment',
                'Date',
            ],
            'rows' => $comments
        ]);
    }
}
