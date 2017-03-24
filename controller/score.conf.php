<?php
/**
 * 积分配置
 * User: chenlin15
 * Date: 17/3/24
 * Time: 15:23
 */

class ScoreConfig {
    //积分配置
    const SUBMITWORK               = 1;//发布作品
    const SUBMITCOMPETITIONEXP     = 2;//发布比赛经验
    const SUBMITWORDMODEL          = 3;//发布文档模板
    const SUBMITPPTMODEL           = 4;//发布ppt模板
    const COMMENT                  = 5;//发布评论
    const VOTE                     = 6;//点赞
    const SUBMITSCORE              = 7;//打分
    const COLLECTED                = 8;//被收藏


    public static $_rules = array(
        self::SUBMITWORK             => 10,
        self::SUBMITCOMPETITIONEXP   => 5,
        self::SUBMITWORDMODEL        => 5,
        self::SUBMITPPTMODEL         => 5,
        self::COMMENT                => 2,
        self::VOTE                   => 2,
        self::COLLECTED              => 2,
    );
}


