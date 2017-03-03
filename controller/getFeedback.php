<?php
/**
 * User: chenlin15
 * Date: 17/2/28
 * Time: 12:25
 */
require "../module/FeedbackModel.php";

class GetFeedbackController {

    public function __construct() {

    }

    public function execute() {
        $feedbackModel = new FeedbackModel();
        $res = $feedbackModel->getFeedbackInfos();
        var_dump($res);
    }
}

$getFeedback = new GetFeedbackController();
$getFeedback->execute();