<?php
class Company extends PbController {
	var $name = "Company";
	
	function Company() {
		global $viewhelper;
		
		$this->loadModel("company");
		$this->loadModel("industry");
		$this->loadModel("point");
		$this->loadModel("shopvote");
		
		$this->viewhelper = $viewhelper;
	}
	
	function index() {
		//echo $_GET["keyword"]."zzzzz";
		//GET TOP INDUSTRY TILES
		$industries = $this->industry->getCacheIndustry();		
		$count0 = 0;
		$fimages = array();
		foreach($industries as $key0 => $level0)
		{
			$cats = array();
			$cats[] = $level0["id"];
			if($count0%6 == 0 || $count0%6 == 5)
			{
				$maxitem = 11;
			}
			else
			{
				$maxitem = 3;
			}
			
			$industries[$key0]["disp"] = "disp";
		
			//getImage
			$industries[$key0]["image"] = pb_get_attachmenturl($industries[$key0]["picture"], "", "");
			
			if(preg_match('/nopicture/', $industries[$key0]["image"]))  $industries[$key0]["image"] = "";
			
			//FACEBOOK IMAGES
			if($industries[$key0]["image"] != '' && $industries[$key0]["share_facebook"])
			{
				$fimages[] = $industries[$key0]["image"];
			}
			
			foreach($level0['sub'] as $key1 => $level1)
			{
				$cats[] = $level1["id"];
				
				foreach($level1['sub'] as $key2 => $level2)
				{
					$cats[] = $level2["id"];
				}

				if($key1 > $maxitem)
				{
					unset($industries[$key0]["sub"][$key1]);
				}
				
			}
			
			if($count0 == count($industries)-1)
			{
				$industries[$key0]["last"] = 1;
			}
			else
			{
				$industries[$key0]["last"] = 0;
			}
			
			$count0++;
		}
		setvar("IndustryList", $industries);
		
		////GET COMPANIES
		//$this->company->initSearch();
		//$companies = $this->company->Search(0, 12);
		//setvar("companies", $companies);
		
		//GET ADSES
		uses("ad","adzone");
		$ads = new Adses();
		$adzones = new Adzones();
		
		$conditions = array();
		$joins = array();
		
		$joins[] = "LEFT JOIN {$ads->table_prefix}companies c ON c.id=Ads.company_id";
		$joins[] = "LEFT JOIN {$ads->table_prefix}members m ON m.id=c.member_id";
		
		//GET CURRENT INDUSTRY	
		if(isset($_GET["industryid"])) {
			$industryid = $_GET["industryid"];
			
			$industry = $this->industry->read("*", intval($_GET["industryid"]));
			//var_dump($industry);
			setvar("industry",$industry);
			
			//conditions
			$conditions[] = "(((c.industries LIKE '".$industryid."')"
							." OR (c.industries LIKE '%,".$industryid."')"
							." OR (c.industries LIKE '".$industryid.",%')"
							." OR (c.industries LIKE '%,".$industryid.",%')) OR ("
					."(Ads.industries LIKE '".$industryid."')"
							." OR (Ads.industries LIKE '%,".$industryid."')"
							." OR (Ads.industries LIKE '".$industryid.",%')"
							." OR (Ads.industries LIKE '%,".$industryid.",%')"
					."))";
		}
		if(!empty($_GET['membergroup_id'])){
 			$conditions[] = "(m.membergroup_id='".intval($_GET['membergroup_id'])."' OR Ads.membergroup_id='".intval($_GET['membergroup_id'])."')";
 		}
		
		$zones = $adzones->findAll("*", null, array("company_zone=1"), "display_order");

		foreach($zones as &$zone) {
			$zone_condition = array("Ads.adzone_id=".$zone["id"]);
			$count = $ads->findCount($joins, array_merge($conditions, $zone_condition), "c.cache_spacename");
			//var_dump($count);
			$count = intval($count/7)*7;
			//var_dump($count);
			$adses = $ads->findAll("c.cache_spacename, c.shop_name as shop_name, c.picture, Ads.*", $joins, array_merge($conditions, $zone_condition), "display_order", 0, $count);
			
			foreach($adses as &$item) {				
				$item = $ads->formatResult($item);
			}
			
			$zone["adses"] = $adses;
		}
		//var_dump($zones);
		
		
		//FIND EFFECTIVE MONTHLY COMPANIES
		$com_conditions = array();
		//check for nice shop with > 9 products
		$other_con = " > 8";
		$company_has_logo = "AND Company.picture != '' AND Company.banners IS NOT NULL";
		$com_conditions[] = "(Company.id IN (".
						"SELECT id FROM (SELECT cc.id, COUNT(pp.id) AS pcount FROM {$this->company->table_prefix}companies AS cc"
						." INNER JOIN {$this->company->table_prefix}products AS pp ON cc.id = pp.company_id"
						." WHERE pp.status=1 GROUP BY cc.id) AS kk WHERE pcount".$other_con.") ".$company_has_logo." )";
		
		
		$com_joins = array("LEFT JOIN {$this->company->table_prefix}members m ON m.id=Company.member_id");
		if(isset($_GET["industryid"])) {
			$industryid = $_GET["industryid"];
			$com_conditions[] = "((Company.industries LIKE '".$industryid."')"
							." OR (Company.industries LIKE '%,".$industryid."')"
							." OR (Company.industries LIKE '".$industryid.",%')"
							." OR (Company.industries LIKE '%,".$industryid.",%'))";
		}
		if(!empty($_GET['membergroup_id'])){
 			$com_conditions[] = "m.membergroup_id=".intval($_GET['membergroup_id']);
 		}
		$companies = $this->company->findAll("Company.*", $com_joins, $com_conditions, "m.points_monthly DESC, m.active_time DESC", 0, 70);
		foreach($companies as $key => $com) {
			$companies[$key] = $ads->formatResult($com);
		}
		$com_zone["name"] = "Gian hàng Nổi bật";
		$com_zone["adses"] = $companies;
		
		$zones[] = $com_zone;
		
		
		
		setvar("list", $zones);
		render("company/index", 1);
	}
	
	function search() {
		$num_per_page = 14;
		$current_page = 1;
		$url = URL."index.php?do=company&action=search&keyword=".$_GET["keyword"];
		
		if(isset($_GET["p"])) {
			$current_page = intval($_GET["p"]);
		}
		
		$offset = ($current_page-1)*$num_per_page;
		
		$result = $this->company->fullTextSearch($_GET["keyword"],$offset,$num_per_page,true);
		foreach($result["result"] as &$item) {
			$item["href"] = $this->company->url(array("module"=>"space","userid"=>$item["cache_spacename"]));
		}
		//var_dump($result);
		setvar("list", $result["result"]);
		setvar("count", $result["count"]);
		setvar("pagination", pagination($url, $result["count"], $num_per_page, $current_page));
		
		//render("company/search", 1);
		//uses("ad");
		//$ads = new Adses();
		//
		//$conditions = array();
		//$joins = array();
		//
		//$joins[] = "LEFT JOIN {$ads->table_prefix}companies c ON c.id=Ads.company_id";
		//$joins[] = "LEFT JOIN {$ads->table_prefix}members m ON m.id=c.member_id";
		//$joins[] = "LEFT JOIN {$ads->table_prefix}adzones ad ON ad.id=Ads.adzone_id";
		//
		//$conditions[] = "ad.company_zone=1";
		//
		//if(trim($_GET["keyword"])) {
		//	$keyword = strtolower(trim($_GET["keyword"]));
		//	$conditions[] = "(Ads.title='' AND (LOWER(c.name) LIKE '%{$keyword}%' OR LOWER(c.shop_name) LIKE '%{$keyword}%'))";
		//}		
		//
		//$adses = $ads->findAll("c.cache_spacename, c.name as company_name, c.picture, Ads.*", $joins, $conditions);
		//foreach($adses as &$item) {				
		//	$item = $ads->formatResult($item);
		//}
		//setvar("list", $adses);
		
		render("company/search", 1);
	}
	
	function detail() {
		global $G;
		using("area","industry");
		$area = new Areas();
		$industry = new Industries();
		$tpl_file = "company/detail";
		$this->viewhelper->setTitle(L("yellow_page", "tpl"));
		$this->viewhelper->setPosition(L("yellow_page", "tpl"), "index.php?do=company");
		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);
			$result = $area->dbstuff->GetRow("SELECT * FROM {$area->table_prefix}companies WHERE id='".$id."'");
			if (!empty($result)) {
				$login_check = 1;//default open
				if(isset($G['company_logincheck'])) $login_check = $G['company_logincheck'];
				$this->viewhelper->setTitle($result['name']);
				$this->viewhelper->setPosition($result['name']);
				$result['tel'] = pb_hidestr(preg_replace('/\((.+?)\)/i', '', $result['tel']));
				$result['fax'] = pb_hidestr(preg_replace('/\((.+?)\)/i', '', $result['fax']));
				$result['mobile'] = pb_hidestr($result['mobile']);
				$result['industry_names'] = $industry->disSubNames($result['industry_id'], null, true, "company");
				$result['area_names'] = $area->disSubNames($result['area_id'], null, true, "company");
				setvar("item", $result);
				setvar("LoginCheck", $login_check);
			}
		}
		render($tpl_file, 1);
	}
	
	function updatePoint() {
		var_dump($this->point->actions);
		
		//$mems = $this->
	}
	
	function rating() {
		$pb_userinfo = pb_get_member_info();
		if($pb_userinfo) {
			$this->shopvote->update($pb_userinfo["pb_userid"], $_GET["space_name"],intval($_GET["star"]));;
		}
		pheader("location:".$_SERVER['HTTP_REFERER']);
	}
	
	function updateAllMonthlyPoint() {
		$this->point->updateAllMonthlyPoint();
	}
	function updateAllWeeklyPoint() {
		$this->point->updateAllWeeklyPoint();
	}
}
?>