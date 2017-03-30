<?php
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');
error_reporting(E_ALL);
header('Content-type: text/html; charset=utf-8');
set_time_limit(0);

include '../controller/global.php';
include URI_HOST . '/crawler/http.php';
include URI_HOST . '/module/CompetitionsModel.php';


class CronSaiKr {
	const URL_HOST = 'http://www.saikr.com';
	public function __construct() {
		$this->run();
	}

	public function run() {
		$http = new Http(1, -1, 60, 60);
		$requestHeader = array(
			'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Accept-Language' => 'zh-CN,zh;q=0.8,en;q=0.6',
			'Cache-Control'   => 'no-cache',
			'Cookie'          => '_msg_lasttime=; sk_session=57eeea6c3d14cc87e8dac27865a2fe5f902ea796; hdmisaslm=716fcb385902d3ddf6c714eca5c0648b; Hm_lvt_f0ef5de4e57d9f0a06baad7f2e18ebb3=1489060226,1489325386; Hm_lpvt_f0ef5de4e57d9f0a06baad7f2e18ebb3=1489325527',
			'Host'            => 'www.saikr.com',
			'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
		);
		$nextUrl = '/vs/0/0/0';
		$urls = array();
		while (true) {
			$url = self::URL_HOST . $nextUrl;
			$response = $http->request($url, '', 'GET', $requestHeader);
			$pattern = '/<a href="(https:\/\/www.saikr.com\/vse.*?)" target="_blank" title=/im';
			preg_match_all($pattern, $response, $matchUrl);
			if (!empty($matchUrl[1])) {
				foreach ($matchUrl[1] as $v) {
					$urls[] = $v;
				}
			}
			$pattern = '/<li class=\'next\'><a href="(\/vs\/0\/0\/0?.*?)" data-ci-pagination-page/im';
			preg_match($pattern, $response, $matchNext);
			if (!empty($matchNext)) {
				$nextUrl = $matchNext[1];
				echo  "\n" .$nextUrl . "\n";
			} else {
				break;
			}
			break;
		}
		$competitionsModel = new CompetitionsModel();
		foreach ($urls as $url) {
			$response = $http->request($url, '', 'GET', $requestHeader);
			preg_match('/<title>(.*?)<\/title>/im', $response,$matchTitle);
			preg_match('/<div class="event4-1-detail-text-box text-body clearfix">([\s\S]*)<div class="event4-1-detail-box event4-1-doc-box">/im', $response,$matchContent);
			if (empty($matchContent)) {
				preg_match('/<div class="event4-1-detail-box">([\s\S]*)<style type="text\/css">/im', $response,$matchContent);
			}
			preg_match('/(<div class="event4-1-detail-box event4-1-doc-box">[\s\S]*)<style type="text\/css">/im', $response, $matchDown);
			preg_match('/(\d{4}年\d{2}月\d{2}日-\d{4}年\d{2}月\d{2}日)/im', $response, $matchTime);
			$matchTime[1] = str_replace('年', '-', $matchTime[1]);
			$matchTime[1] = str_replace('月', '-', $matchTime[1]);
			$matchTime[1] = str_replace('日', '', $matchTime[1]);
			$start_time = substr($matchTime[1], 0, 10);
			$end_time = substr($matchTime[1], 11);
			$addArr = array(
				'`title`'       => empty($matchTitle) ? '' : $matchTitle[1],
				'`content`'     => empty($matchContent) ? '' : $matchContent[1],
				'`create_time`' => time(),
				'`status`'      => COMPETITION_STATUS_NOMAL,
				'`download`'    => empty($matchDown) ? '' : $matchDown[1],
				'`start_time`'  => empty($start_time) ? '' : $start_time,
				'`end_time`'    => empty($end_time) ? '' : $end_time,
			);
			//$file = '/Users/chenlin15/Documents/out.txt';
			//$str = "[title] : " . $addArr['`title`'] . "\n[content] : " . $addArr['`content`'] . "\n[create_time] : " . $addArr['`create_time`'] . "\n[download] : " . $addArr['`download`'] . "\n[start_time] : " . $addArr['`start_time`'] . "\n[end_time] : " . $addArr['`end_time`'];
			//file_put_contents($file, $str);exit;
			$res = $competitionsModel->addCompetitions($addArr);
			if (false === $res) {
				echo "\ninsert [" . $url . "] 错误!! \n";
			}
		}
	}
}

new CronSaiKr();